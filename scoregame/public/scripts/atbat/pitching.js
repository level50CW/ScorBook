function PitchingController(){
    var self = this;

    var pitchColors = {
        strike: 'blue',
        ball: 'green',
        out: 'red',
        hit: 'yellow',
        foul: 'gray'
    };

    var pitchingState,
        isPitchingEvent,
        pitchingType,
        strikeType,
        pitchCounter,
        isEnabled,
        $lastPoint,
        isTrackerEnabled,
        isTrackerDisabled,
        createNewPitch;

    resetGlobals();
    function resetGlobals(){
        pitchingState = 'none'; // none, pitch, menu
        isPitchingEvent = false;
        pitchingType = null;
        strikeType = null;
        pitchCounter = {
            total: 0,
            strike: 0,
            ball: 0,
            out: 0
        }; // state
        isEnabled = false;
        $lastPoint = null;
        isTrackerEnabled = G.isPitchTrackingEnabled;
        isTrackerDisabled = !G.isPitchTrackingEnabled;

        createNewPitch = false;

        $('.js-pitch-region').children('.ui-circle').remove();
    }

    function updateEvents(){
        if (pitchCounter.strike == 3){
            self.enable(false);
            self.on3Strikes(strikeType);
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

        if (type == 'foul' && pitchCounter.strike < 2){
            pitchCounter.strike++;
        } else {
            pitchCounter[type]++;
        }

        pitchCounter.total++;

        if (pitchCounter.strike < 3)
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

        self.storage.updatePitch({
            type: 'hit',
            type2: type
        });

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
        var $region = $('.js-pitch-region');
        var regionOffset = $region.offset();

        self.storage.forEach(['pitch'],{
            pitch: function(o){
                var pitch = o.pitch;

                if (pitch.coordinatesCatch && regionOffset) {
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
        });

        // TODO: Logic is not correct
        if (isTrackerDisabled)
            $lastPoint = $('<div>');
    }

    function tryAddPitchUi(type){
        if (pitchCounter.strike>=3 || pitchCounter.ball>=4)
            return;

        if (!isPitchingEvent || !$lastPoint){
            return;
        }


        if (isTrackerDisabled) {
            //self.storage.newPitch();

            addPitch(type);

            self.storage.updatePitch({
                number: pitchCounter.total
            });
            self.onPitch();

            createNewPitch = true;
            return;
        }

        pitchingType = type;
        $lastPoint.attr('color',pitchColors[pitchingType]);

        addPitch(type);

        self.storage.updatePitch({
            number: pitchCounter.total
        });

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
        pitchingState = 'none';
        self.onEnable(false);
        createNewPitch = true;

        //if (isTrackerDisabled){
        //    isPitchingEvent = true;
        //    pitchingState = 'pitch';
        //    self.onBeforePitch();
        //    $lastPoint = $('<div>');
        //    self.onEnable(true);
        //}
    }

    $('.js-button-pitch').click(function(){
        if (isEnabled && !$lastPoint && pitchingState == 'none') {
            isPitchingEvent = true;
            pitchingState = 'pitch';
            self.onBeforePitch();
        }
    });

    $('.js-pitch-type').click(function(){
        if (!isPitchingEvent || $(this).attr('type') == 'out' ||
            isTrackerDisabled || !$lastPoint){
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

    //$('.js-pitch-type .ui-circle[value]').click(function(){
    //    if (isTrackerEnabled || !isPitchingEvent)
    //        return;
    //
    //    var $current = $(this);
    //    var $parent = $current.parent();
    //
    //    setPitch($parent.attr('type'), +$current.attr('value'));
    //});

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

            //self.storage.newPitch();
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

    $('.js-button-field-ball').click(function(){
        tryAddPitchUi('ball');
    });

    $('.js-button-field-strike-looking').click(function(){
        strikeType = 'KL';
        tryAddPitchUi('strike');
    });

    $('.js-button-field-strike-swinging').click(function(){
        strikeType = 'KSW';
        tryAddPitchUi('strike');
    });

    $('.js-button-field-ball-foul').click(function(){
        tryAddPitchUi('foul');
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

        $('.js-pitch-region').children('.ui-circle').remove();

        isPitchingEvent = false;
        pitchingType = null;
        $lastPoint = null;
        pitchingState = 'none';

        self.enable(true);
        self.onEnable(false);

        createNewPitch = true;

        // TODO: Duplicated code line 212
        if (isTrackerDisabled){
            isPitchingEvent = true;
            pitchingState = 'pitch';
            self.onBeforePitch();
            $lastPoint = $('<div>');
            self.onEnable(true);
        }
    };

    self.addOut = function(){

        // Current state can not have 3 outs (Undo problem)
        // storage monitor outs by pitch counter
        //self.storage.updateState({ outs: pitchCounter.out });

        pitchCounter.out++;

        if (pitchCounter.out == 3){
            self.enable(false);
            self.on3Outs();
        }

        self.storage.updatePitch({ counter: pitchCounter });

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
        resetGlobals();
        self.reset();
        restoreCounter();
        restorePitches();
    };

    self.tryCreatePitch = function(){
        if (createNewPitch){
            createNewPitch = false;
            self.storage.newPitch();
        }
    };

    return self;
}