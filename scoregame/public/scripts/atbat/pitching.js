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
        var $list = $('.js-pitch-list');
        var $container = $('<div class="ui-pitch-status-part">');
        $container.append(pitchPaterns[type]);
        $list.append($container);
        pitchCounter[type]++;
        pitchCounter.total++;

        self.storage.updatePitch({
            type: type,
            counter: pitchCounter
        });

        updatePitchUi();
        updateEvents();
    }

    function addHitPitch(type){
        var $list = $('.js-pitch-list');
        var $container = $('<div class="ui-pitch-status-part">');
        $container.append(pitchPaterns['hit']).children('span').text('HIT-'+type);
        $list.append($container);
        $lastPoint.attr('color',pitchColors['hit']);

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
    }

    function addOutPitch(type){
        var $list = $('.js-pitch-list');
        var $container = $('<div class="ui-pitch-status-part">');
        $container.append(pitchPaterns['out']).children('span').text('OUT-'+type);
        $list.append($container);
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
        var $list = $('.js-pitch-list');
        var regionOffset = $region.offset();

        for(var p in state.pitches){
            var pitch = state.pitches[p];

            $lastPoint = $('<div class="ui-circle" hastext="1">')
                .text(pitch.number)
                .appendTo($region)
                .offset({
                    top: pitch.coordinatesCatch.y + regionOffset.top,
                    left: pitch.coordinatesCatch.x + regionOffset.left
                });

            if (pitch.type){
                var $container = $('<div class="ui-pitch-status-part">');

                if (pitch.type == 'hit')
                    $container.append(pitchPaterns['hit']).children('span').text('HIT-'+pitch.type2);
                else
                    $container.append(pitchPaterns[pitch.type]);

                $list.append($container);


                $lastPoint.attr('color',pitchColors[pitch.type]);
                $lastPoint = null;
            } else {
                isPitchingEvent = true;
                self.onEnable(true);
            }
        }


    }

    $('.js-button-pitch').click(function(){
        isPitchingEvent = isEnabled;
        if (isPitchingEvent && !$lastPoint)
            self.onBeforePitch();
    });

    $('.js-pitch-type').click(function(){
        if (!$lastPoint || !isPitchingEvent || $(this).attr('type') == 'out')
            return;

        pitchingType = $(this).attr('type');
        $lastPoint.attr('color',pitchColors[pitchingType]);

        addPitch(pitchingType);

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
        self.onEnable(false);
    });

    $('.js-pitch-region').mousedown(function(e){
        if (isPitchingEvent && !$lastPoint){
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


    self.reset = function(){
        pitchCounter.out = 0;
        self.resetPitching();
    };

    self.resetPitching = function(){
        pitchCounter.strike = 0;
        pitchCounter.ball = 0;
        pitchCounter.total = 0;
        updatePitchUi();

        $('.js-pitch-list').children().remove();
        $('.js-pitch-region').children('div').remove();

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;

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

    self.enable = function(isEnable){
        var button = $('.js-button-pitch');
        if(isEnable)
            button.removeAttr('disabled');
        else
            button.attr('disabled',1);


        isEnabled = isEnable;
    };

    self.restore = function(){
        restoreCounter();
        restorePitches();
    };

    return self;
}