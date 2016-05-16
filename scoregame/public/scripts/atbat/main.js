G = {};

$('body').ready(function(){
    var $lineups = $('.js-lineup');
    var $scorepads = $('.js-scorepad');
    $lineups['visitor'] = $lineups.eq(0);
    $lineups['home'] = $lineups.eq(1);
    $scorepads['visitor'] = $scorepads.eq(0);
    $scorepads['home'] = $scorepads.eq(1);

    var pitcherController = new PitchingController();
    var inningController = new InningController();
    var fielderController = new FieldController();
    var hitController = new HitController();
    var graphicsController = new GraphicsController();
    var strikeController = new StrikeController();
    var outController = new OutController();
    var miscController = new MiscController();
    var errorController = new ErrorController();
    var advanceController = new AdvanceController();
    var requestController = new RequestController();
    var storageController = new StorageController();
    var ballInPlayController = new BallInPlayController();
    var gameLogController = new GameLogController();
    var playerController = new PlayerController();
    var scorepadController = new ScorePadController();


    requestController.register(storageController);

    storageController.register(pitcherController);
    storageController.register(inningController);
    storageController.register(fielderController);
    storageController.register(hitController);
    storageController.register(graphicsController);
    storageController.register(strikeController);
    storageController.register(outController);
    storageController.register(miscController);
    storageController.register(gameLogController);
    storageController.register(playerController);
    storageController.register(scorepadController);

    playerController.register(inningController);
    playerController.register(fielderController);
    playerController.register(gameLogController);

    G._debug = {
        storageController: storageController,
        fielderController: fielderController
    };


    var sleepData = {
        callbackSequence: [],
        lastHandle: -1,
        isSleep: false
    };

    //function registerLogging(obj){
    //    for(var pr in obj){
    //        if (typeof obj[pr] == "function"){
    //            var func = obj[pr]
    //        }
    //    }
    //
    //    console.log(arguments);
    //}

    function log(){
        console.log(arguments);
    }

    function initLineupSwitching(){
        $('.js-button-lineup').click(function () {
            $('.js-button-lineup').removeAttr('selected');
            $lineups.hide();
            $scorepads.hide();

            $(this).attr('selected',1);
            $lineups[$(this).attr('team')].show();
            $scorepads[$(this).attr('team')].show();
        });

        $('.js-button-lineup[team=visitor]').click();
    }

    function initContainerSwitching(){
        $('.js-button-container').click(function () {
            $('.js-button-container').removeAttr('selected');
            $('.js-container-lineup').hide();
            $('.js-container-scorepad').hide();

            $(this).attr('selected',1);
            $('.js-container-' + $(this).attr('type')).show();
        });

        $('.js-button-container[type=lineup]').click();
    }

    function initScrollBar(){
        $('.js-container-scrollbar').height($('.js-table-left-div').height()-52);
    }

    function selectLineup(type){
        if (type == 'home')
            $('.js-button-lineup[team=home]').click();
        else
            $('.js-button-lineup[team=visitor]').click();
    }

    function sleep(callback){
        if (sleepData.lastHandle == -1){
            sleepData.lastHandle = setTimeout(function(){
                for(var i in sleepData.callbackSequence){
                    sleepData.callbackSequence[i]();
                }
                sleepData.callbackSequence = [];
                sleepData.lastHandle = -1;
            }, 2000);
        }

        sleepData.callbackSequence.push(callback);
    }

    function sleepNextBatter(){
        fielderController.doAdvancedBatterBase();
        pitcherController.disableMenu();
        sleep(function(){
            fielderController.clearMarks();
            inningController.nextBatter();

            inningController.updateLineup();
            var gameSet = inningController.getGameSet();
            fielderController.setGameSet(gameSet);
            fielderController.updateLineup();

            scorepadController.update();

            // TODO: Fix this
            storageController.storeState(function(){});
        });
    }

    function restore(){
        inningController.restore();

        var gameSet = inningController.getGameSet();

        pitcherController.restore();
        fielderController.restore(gameSet);
        gameLogController.restore();

        scorepadController.restore();

        selectLineup(gameSet.offenceLineup.type);
    }

    function tryRestoreFromServer(){
        if (G.gameStatus == 1) {
            storageController.restoreState(function () {
                restore();
            });
        }
    }

    function enableButtons(isEnable){
        hitController.enable(isEnable);
        outController.enable(isEnable);
        errorController.enable(isEnable);
        advanceController.enable(isEnable);
    }

    pitcherController.on3Strikes = function(type){
        strikeController.enable(true);
        strikeController.menuHandle(type);
    };

    pitcherController.on4Balls = function(){
        inningController.addBothScore('BB');
        fielderController.doAutoBatterBase();
        graphicsController.drawLabel('BB');
        sleepNextBatter();
    };

    pitcherController.on3Outs = function(){
        inningController.do3Outs();
    };

    pitcherController.onBeforePitch = function(){
        miscController.enable(true);
        hitController.enableParticular(true);
    };

    pitcherController.onPitch = function(){
        inningController.updatePitchActors();
        inningController.addPitchScore('PC');
        gameLogController.addPitchCount();
        gameLogController.update();
        miscController.enable(false);
    };

    pitcherController.onEnable = function(isEnable){
        enableButtons(isEnable);
    };

    pitcherController.onAddLog = function(type, text){
        gameLogController.addItem(type,text);
        gameLogController.update();
    };

    inningController.onBatterReady = function(batter){
        pitcherController.resetPitching();
        fielderController.setCurrentBatter(batter);
        graphicsController.clear();
    };

    inningController.onNextGameSet = function(){
        var gameSet = inningController.getGameSet();
        fielderController.setGameSet(gameSet);
        fielderController.resetFielders();
        pitcherController.reset();
        miscController.enable(false);
        selectLineup(gameSet.offenceLineup.type);
    };

    inningController.onGameEnd = function(status, winner){
        pitcherController.reset();
        pitcherController.enable(false);
        fielderController.clear();
        graphicsController.clear();

        enableButtons(false);

        requestController.setGameStatus(status, function(data){
            if (data.success){
                storageController.storeState(function(){
                    if (!winner)
                        alert('The winner is undefined');
                    else if (winner == 'deadheat')
                        alert('Game is finished with dead heat');
                    else
                        alert('The '+winner+' team wins the game');
                });
            }
        });
    };

    fielderController.onAddInningScore = function(batter){
        inningController.addBatterScore(batter, 'R');
        inningController.addPitchScore('R');
        inningController.addBatterScore('RBI');
        inningController.addInningRunScore();
    };

    fielderController.onBatterRun = function(base){
        graphicsController.drawRun(base);
    };

    fielderController.onBatterFielderClick = function(obj){
        outController.doClick(obj);
        miscController.doClick(obj);
        errorController.doClick(obj);
        advanceController.doClick(obj);
    };

    hitController.onBatterHit = function(type){
        fielderController.doBatterHit(type);
        inningController.addBatterScore('AB');
        inningController.addBatterScore('H');
        inningController.addPitchScore('H');
        inningController.addInningHitScore();
        pitcherController.addHitPitch(type);
        pitcherController.enable(false);
        enableButtons(false);
        sleepNextBatter();
    };

    hitController.onPitchError = function(type){
        if (type != 'CI')
            inningController.addPitchScore('ER');
        pitcherController.addHitPitch(type);
        // TODO: Incorrect behavior: addHitPitch should call before doAutoBatterBase (onUpdatePitch)

        if (type == 'BK')
            fielderController.doBatterBaseForce(3,0);
        else
            fielderController.doAutoBatterBase();

        pitcherController.enable(false);
        enableButtons(false);
        graphicsController.drawLabel(type);
        sleepNextBatter();
    };

    hitController.onDrawHit = function(point){
        graphicsController.clear();
        graphicsController.drawHit(point);
    };

    hitController.onDrawLabel = function(type){
        graphicsController.drawLabel(type);
    };

    strikeController.onStrikeOut = function(type){
        inningController.addBothScore('SO');
        inningController.addBatterScore('AB');
        graphicsController.drawStateLabel('K');
        fielderController.doBatterOut();
        pitcherController.addOut();
        pitcherController.addOutPitch(type);
        pitcherController.enable(false);
        sleepNextBatter();
    };

    outController.onOut = function(type, fielders, batters){
        pitcherController.addOutPitch(type);
        hitController.enable(false);

        if (type != 'SF' && type != 'SH')
            inningController.addBatterScore('AB');

        if (batters.length > 0) {
            graphicsController.drawStateLabel(type + ' ' + fielders.join('-'));
        }
        fielderController.markBatterBase();
        fielderController.doBattersOut(batters);
        fielderController.doBatterBase();
        for (var k in batters)
            pitcherController.addOut();
        pitcherController.enable(false);
        enableButtons(false);
        sleepNextBatter();
    };

    outController.onDrawHit = function(point){
        graphicsController.clear();
        graphicsController.drawHit(point);
    };

    outController.onBatterBase = function(toBase){
        toBase = toBase || 1;
        fielderController.doBatterBaseForce(3,toBase);
    };

    miscController.onOut = function(batter){
        pitcherController.addOut();
        graphicsController.drawStateLabel('CS'+' '+(batter<3? (batter+1)+'B' : 'Home'));
        fielderController.doBattersOut([batter]);
        fielderController.updateBatters();
        fielderController.storeBaseState([]);
        sleep(function(){
            if (inningController.tryDoNextGameSet())
                storageController.storeState(function(){});
        });
    };

    miscController.onBatterBase = function(batter){
        fielderController.doBatterBaseForce(batter,batter);
        graphicsController.drawStateLabel('SB'+' '+(batter<3? (batter+1)+'B' : 'Home'));
    };

    errorController.onError = function(val){
        inningController.addInningErrorScore();
    };

    storageController.onUpdatePitch = function(){
        storageController.onUpdateState();
        pitcherController.tryCreatePitch();
    };

    storageController.onUpdateState = function() {
        inningController.tryCreateState();
    };

    ballInPlayController.onMenu = function(type, item){
        switch(type){
            case 'hit': return hitController.menuHandle(item);
            case 'out': return outController.menuHandle(item);
            case 'strike': return strikeController.menuHandle(item);
            case 'error': return errorController.menuHandle(item);
            case 'misc': return miscController.menuHandle(item);
            case 'advance': return advanceController.menuHandle(item);
        }
        return false;
    };

    gameLogController.onGetCurrentTeamBatter = function(){
        var gameSet = inningController.getGameSet();
        var batter = inningController.getCurrentBatter();

        return {
            lineup: gameSet.offenceLineup.name,
            batter: batter.name
        };
    };

    G.onUpdateGameStatus = function(gamestatus){
        switch(gamestatus){
            case 1:
                requestController.getGameStatus(function(data){
                    if (data.status == 1) {
                        alert('Game is in progress');
                        return;
                    }

                    if (data.status >= 2 && (data.status <= 9)){
                        alert('Game is over. You can not start finished game.');
                        return;
                    }

                    if (data.status == 0){
                        requestController.setGameStatus(gamestatus, function(data){
                            if (data.success){
                                G.gameStatus = 1;
                                inningController.startGame();
                                scorepadController.restore();
                                storageController.storeState(function () {});
                            }
                        });
                    }
                });
                break;
            default:
                requestController.getGameStatus(function(data){
                    if (data.status == 0) {
                        alert('Game is not started. You can not finish the game before start.');
                        return;
                    }

                    if (data.status >= 2 && (data.status <= 9)){
                        alert('Game is already over.');
                        return;
                    }

                    if (data.status == 1) {
                        inningController.endGame(gamestatus);
                    }
                });
                break;
        }
    };

    G.onDebug = function(item){
        if (item == 'getJson'){
            console.log(JSON.stringify(storageController));
        }

        if (item == 'restore'){
            var obj = JSON.parse('{"currentInning":0,"currentState":3,"currentPitch":0,"innings":[{"state":[{"pitches":[{"coordinatesCatch":{"x":98.09375,"y":33},"number":1,"type":"hit","type2":"2B","coordinatesHit":{"x":246.09375,"y":40}}],"playerScores":[{"id":3485,"type":"batters","score":"AB"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3485,"type":"batters","score":"H"},{"id":3505,"type":"pitchers","score":"H"}],"inningScores":[{"type":"visitor","score":"H"}],"offence":"visitor","defence":"home","pitcher":3505,"outs":0,"batter":1},{"pitches":[{"coordinatesCatch":{"x":82.09375,"y":79},"number":1,"type":"ball","counter":{"total":1,"strike":0,"ball":1,"out":0}},{"coordinatesCatch":{"x":106.09375,"y":51},"number":2,"type":"ball","counter":{"total":2,"strike":0,"ball":2,"out":0}},{"coordinatesCatch":{"x":46.09375,"y":44},"number":3,"type":"ball","counter":{"total":3,"strike":0,"ball":3,"out":0}},{"coordinatesCatch":{"x":89.09375,"y":98},"number":4,"type":"ball","counter":{"total":4,"strike":0,"ball":4,"out":0}}],"playerScores":[{"id":3486,"type":"batters","score":"AB"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3486,"type":"batters","score":"BB"},{"id":3505,"type":"pitchers","score":"BB"}],"inningScores":[],"offence":"visitor","defence":"home","pitcher":3505,"outs":0,"batter":2},{"pitches":[{"coordinatesCatch":{"x":103.09375,"y":53},"number":1,"type":"strike","counter":{"total":1,"strike":1,"ball":0,"out":1},"type2":"swinging"}],"playerScores":[{"id":3487,"type":"batters","score":"AB"},{"id":3505,"type":"pitchers","score":"IP"},{"id":3487,"type":"batters","score":"SO"},{"id":3505,"type":"pitchers","score":"SO"}],"inningScores":[],"offence":"visitor","defence":"home","pitcher":3505,"outs":1,"batter":3},{"pitches":[{"coordinatesCatch":{"x":87.09375,"y":63},"number":1,"type":"ball","counter":{"total":1,"strike":0,"ball":1,"out":1}}],"playerScores":[{"id":3488,"type":"batters","score":"AB"},{"id":3505,"type":"pitchers","score":"IP"}],"inningScores":[],"offence":"visitor","defence":"home","pitcher":3505,"outs":1,"batter":4}],"bases":[{"id":-1,"bases":[],"runs":[]},{"id":0,"bases":[null,null,3485],"runs":[0,1]},{"id":13,"bases":[null,3486,3485],"runs":[0]},{"id":20,"bases":[null,3486,3485],"runs":[]}]}]}');
            storageController.setData(obj);

            inningController.restore();

            var gameSet = inningController.getGameSet();

            pitcherController.reset();
            pitcherController.restore();
            fielderController.setGameSet(gameSet);
            fielderController.restore();

            selectLineup(gameSet.offenceLineup.type);
        }

        if (item == 'undo'){
        }
    };

    G.onRedirect = function(url){
        if (G.gameStatus && G.gameStatus == 1) { // game in progress
            if (sleepData.lastHandle == -1) // not wait next
                storageController.storeState(function () {
                    location = url;
                });
        } else {
            location = url;
        }
    };

    initContainerSwitching();
    initLineupSwitching();
    initScrollBar();

    tryRestoreFromServer();

    $('.js-button-game-undo').click(function(){
        storageController.undoBy('pitch');
        restore();
    });
});