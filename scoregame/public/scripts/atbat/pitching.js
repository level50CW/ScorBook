function PitchingController(){
    var self = this;


    var pitchPaterns = {
        strike: '<span>STRIKE</span><div class="ui-circle" color="blue">',
        ball: '<span>BALL</span><div class="ui-circle" color="green">',
        hit: '<span></span><div class="ui-circle" color="yellow">',
        out: '<span></span><div class="ui-circle" color="red">'
    };

    var pitchColors = {
        strike: 'blue',
        ball: 'green',
        out: 'red',
        hit: 'yellow'
    };

    var pitchingState = 'none'; // none, pitch, menu
    var isPitchingEvent = false;
    var pitchingType = null;
    var pitchCounter = {
        total: 0,
        strike: 0,
        ball: 0,
        out: 0
    }; // state
    var isEnabled = false;
    var $lastPoint = null;
    var isTrackerEnabled = G.isPitchTrackingEnabled;

    function updateEvents(){
        if (pitchCounter.strike == 3){
            self.enable(false);
            self.on3Strikes();
        }
        if (pitchCounter.ball == 4){
            self.enable(false);
            self.on4Balls();
        }
    }

    function updatePitchUi(){
        var pitchScores = $('.js-pitch-type');
        function update($el,i, type) {
            if (i < pitchCounter[type])
                $el.attr('color', pitchColors[type]);
            else
                $el.removeAttr('color');
        }
        pitchScores.eq(0).children('.ui-circle').each(function(i){
            update($(this),i,'ball');
        });
        pitchScores.eq(1).children('.ui-circle').each(function(i){
            update($(this),i,'strike');
        });
        pitchScores.eq(2).children('.ui-circle').each(function(i){
            update($(this),i,'out');
        });
    }

    function addPitch(type){
        pitchCounter[type]++;
        pitchCounter.total++;

        if (pitchCounter.strike<3)
            self.onAddLog(type);

        self.storage.updatePitch({
            type: type,
            counter: pitchCounter
        });

        updatePitchUi();
        updateEvents();
    }

    function setPitch(type, val){
        pitchCounter.total -= pitchCounter[type];
        pitchCounter[type] = val;
        pitchCounter.total += pitchCounter[type];

        updatePitchUi();
    }

    function addHitPitch(type){
        self.onAddLog('hit',type);

        $lastPoint.attr('color',pitchColors['hit']);

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
    }

    function addOutPitch(type){
        self.onAddLog('out',type);

        if ($lastPoint) //if strikeout $lastPoint == null
            $lastPoint.attr('color',pitchColors['out']);

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
    }

    function restoreCounter(){
        var state = self.storage.getState();
        var pitch = self.storage.getPitch();
        if (pitch){
            $.extend(pitchCounter, pitch.counter);
        }
        pitchCounter.out = state.outs || 0;
        updatePitchUi();
    }

    function restorePitches(){
        var state = self.storage.getState();

        var $region = $('.js-pitch-region');
        var regionOffset = $region.offset();

        for(var p in state.pitches){
            var pitch = state.pitches[p];

            if (pitch.coordinatesCatch) {
                $lastPoint = $('<div class="ui-circle" hastext="1">')
                    .text(pitch.number)
                    .appendTo($region)
                    .offset({
                        top: pitch.coordinatesCatch.y + regionOffset.top,
                        left: pitch.coordinatesCatch.x + regionOffset.left
                    });
            } else{
                $lastPoint = $('<div>');
            }

            if (pitch.type){
                $lastPoint.attr('color',pitchColors[pitch.type]);
                $lastPoint = null;
            } else {
                isPitchingEvent = true;

                if (isTrackerEnabled){
                    self.onEnable(true);
                } else {
                    self.onBeforePitch();
                }
            }
        }
    }

    $('.js-button-pitch').click(function(){
        if (isEnabled && !$lastPoint && pitchingState == 'none') {
            isPitchingEvent = true;
            pitchingState = 'pitch';
            self.onBeforePitch();

            if (!isTrackerEnabled){
                $lastPoint = $('<div>');
            }
            return;
        }

        if (isPitchingEvent && !isTrackerEnabled && $lastPoint && pitchingState == 'pitch'){

            self.storage.newPitch();
            self.storage.updatePitch({
                number: pitchCounter.total,
                counter: pitchCounter
            });

            var pitches = pitchCounter.total;
            while(pitches-- >= 0)
                self.onPitch();
            self.onEnable(true);

            isPitchingEvent = false;
            pitchingType = null;

            if (pitchCounter.ball == 4 || pitchCounter.strike == 3) {
                self.onEnable(false);
                updateEvents();
            }

            if (pitchCounter.ball != 4)
                pitchingState = 'menu';
        }

        if (pitchingState == 'menu'){
            $('.js-button-pitch-menu').click();
        }
    });

    $('.js-pitch-type').click(function(){
        if (!isPitchingEvent || $(this).attr('type') == 'out' ||
            !isTrackerEnabled || !$lastPoint){
            return;
        }

        pitchingType = $(this).attr('type');
        $lastPoint.attr('color',pitchColors[pitchingType]);

        addPitch(pitchingType);

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
        pitchingState = pitchCounter.strike == 3? 'menu': 'none';
        self.onEnable(false);
    });

    $('.js-pitch-type .ui-circle[value]').click(function(){
        if (isTrackerEnabled || !isPitchingEvent)
            return;

        var $current = $(this);
        var $parent = $current.parent();

        setPitch($parent.attr('type'), +$current.attr('value'));
    });

    $('.js-pitch-region').mousedown(function(e){
        if (isPitchingEvent && !$lastPoint && isTrackerEnabled){
            var regionOffset = $(this).offset();
            var x = e.pageX - regionOffset.left - 10;
            var y = e.pageY - regionOffset.top - 10;

            $lastPoint = $('<div class="ui-circle" hastext="1">')
                .text(pitchCounter.total+1)
                .appendTo(this)
                .offset({
                    top: y + regionOffset.top,
                    left: x + regionOffset.left
                });

            self.storage.newPitch();
            self.storage.updatePitch({
                coordinatesCatch: {
                    x: x,
                    y: y
                },
                number: pitchCounter.total+1,
                counter: pitchCounter
            });

            self.onPitch();

            pitchingState = 'menu';
            self.onEnable(true);
        }
    });

    self.on4Balls = function(){
    };
    self.on3Strikes = function(){
    };
    self.on3Outs = function(){
    };
    self.onBeforePitch = function(){
    };
    self.onPitch = function(){
    };
    self.onEnable = function(isEnabled){
    };
    self.onAddLog = function(type, text){};


    self.reset = function(){
        pitchCounter.out = 0;
        self.resetPitching();
    };

    self.resetPitching = function(){
        pitchCounter.strike = 0;
        pitchCounter.ball = 0;
        pitchCounter.total = 0;
        updatePitchUi();

        $('.js-pitch-region').children('div').remove();

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
        pitchingState = 'none';

        self.enable(true);
        self.onEnable(false);
    };

    self.addOut = function(){
        pitchCounter.out++;

        if (pitchCounter.out == 3){
            self.enable(false);
            self.on3Outs();
        }

        self.storage.updatePitch({ counter: pitchCounter });
        self.storage.updateState({ outs: pitchCounter.out });

        updatePitchUi();
    };

    self.addHitPitch = function(type){
        addHitPitch(type);
    };

    self.addOutPitch = function(type){
        addOutPitch(type);
    };

    self.checkPitchingEvent = function(){
        return isPitchingEvent;
    };

    self.disableMenu = function(){
        pitchingState = 'none';
    };

    self.enable = function(isEnable){
        var button = $('.js-button-pitch');
        if(isEnable) {
            button.removeAttr('disabled');
        } else {
            button.attr('disabled', 1);
            button.contextMenu(false);
        }


        isEnabled = isEnable;
    };

    self.restore = function(){
        restoreCounter();
        restorePitches();
    };

    return self;
}