function InningController(lineups){
    var self = this;

    var $lineups,
        defenceLineup,
        offenceLineup,
        $defenceLineup,
        $offenceLineup;

    var gameStarted = false;

    var currentPitcher = null; // state
    var currentBatter = null; // state
    var nextBatter = null; // state
    var currentInning = 0; // 1-9 // state
    var winner = null; // state
    var outs3 = false;
    var lastBatterNumber = 1;

    var inningCounter = {
        visitor: 0,
        home: 0
    }; // state

    var inningTotal = {
        visitor: {R: 0, H: 0, E: 0},
        home: {R: 0, H: 0, E: 0}
    }; // state

    var scoring = null; // state
    var $scoring = null;

    function initScoring(){
        scoring = {
            batters: {},
            pitchers: {}
        };

        $scoring = {
            batters: {},
            pitchers: {}
        };

        function addBatters(team){
            for(var pi in lineups[team].batters){
                var player = lineups[team].batters[pi];
                $scoring.batters[player.id] = $lineups[team].find('.js-lineup-batter[batter='+player.batter+']');
                scoring.batters[player.id] = {
                    player: player,
                    AB: 0,
                    R: 0,
                    H: 0,
                    RBI: 0,
                    BB: 0,
                    SO: 0
                };
            }
        }

        function addPitchers(team){
            var teamOpponent = (team == 'home')? 'visitor' : 'home';
            for(var pi in lineups[team].pitchers){
                var player = lineups[team].pitchers[pi];
                $scoring.pitchers[player.id] = $lineups[teamOpponent].find('.js-lineup-pitcher[batter='+player.batter+']');
                scoring.pitchers[player.id] = {
                    player: player,
                    IP: 0,
                    PC: 0,
                    H: 0,
                    R: 0,
                    ER: 0,
                    BB: 0,
                    SO: 0
                };
            }
        }

        addBatters('home');
        addPitchers('home');
        addBatters('visitor');
        addPitchers('visitor');
    }

    function restoreScoring(){
        for(var i in self.storage.innings)
            for(var s in self.storage.innings[i].state)
                for(var sc in self.storage.innings[i].state[s].playerScores){
                    var score = self.storage.innings[i].state[s].playerScores[sc];
                    var val = ++scoring[score.type][score.id][score.score];
                    $scoring[score.type][score.id]
                        .children('td[type='+score.score+']')
                        .text(val);
                }
    }


    function addScore(player, playertype, scoretype){
        var val = ++scoring[playertype][player.id][scoretype];

        self.storage.addPlayerScore(player.id,playertype,scoretype);

        // TODO: Replace UI update
        $scoring[playertype][player.id]
            .children('td[type='+scoretype+']')
            .text(val);
    }


    function initLineups(){
        $lineups = $('.js-lineup');
        $lineups['visitor'] = $lineups.eq(0);
        $lineups['home'] = $lineups.eq(1);

        var state = self.storage.getState();
        if (state.offence && state.defence){

            defenceLineup = lineups[state.defence];
            offenceLineup = lineups[state.offence];
            $defenceLineup = $lineups[state.defence];
            $offenceLineup = $lineups[state.offence];

            currentPitcher = defenceLineup.getPlayer(state.pitcher, 'pitchers');

        } else {

            defenceLineup = lineups.home;
            offenceLineup = lineups.visitor;
            $defenceLineup = $lineups['home'];
            $offenceLineup = $lineups['visitor'];

            currentPitcher = defenceLineup.pitchers[0];

            self.storage.updateState({
                offence: offenceLineup.type,
                defence: defenceLineup.type,
                pitcher: currentPitcher.id,
                outs: 0
            });
        }
    }

    function resetInningCounter(){
        inningCounter.visitor = 0;
        inningCounter.home = 0;
    }

    function restoreInningCounters(){
        for(var i in self.storage.innings) {
            inningCounter.visitor = 0;
            inningCounter.home = 0;

            for (var s in self.storage.innings[i].state)
                for (var sc in self.storage.innings[i].state[s].inningScores) {
                    var score = self.storage.innings[i].state[s].inningScores[sc];

                    if (score.score == 'R'){
                        inningCounter[score.type]++;
                    }
                    inningTotal[score.type][score.score]++;
                }

            updateScoreUi(+i+1);
        }
    }

    function setCurrentBatter(number){
        currentBatter = offenceLineup.batters[number-1];
        if (number < 9)
            nextBatter = offenceLineup.batters[number];
        else
            nextBatter = offenceLineup.batters[0];

        self.storage.updateState({ batter: number});

        updateInningBatterUi();
    }

    function restoreCurrentBatter(){
        var state = self.storage.getState();
        setCurrentBatter(state.batter);
    }

    function restoreLastBatter(){
        lastBatterNumber = 1;
        var inning = self.storage.getInning();
        for(var s in inning.state){
            var state = inning.state[s];
            if (state.lastBatterNumber){
                lastBatterNumber = state.lastBatterNumber;
            }
        }
    }

    function switchLineups(){
        var buff = defenceLineup;
        defenceLineup = offenceLineup;
        offenceLineup = buff;
        buff = $defenceLineup;
        $defenceLineup = $offenceLineup;
        $offenceLineup = buff;

        currentPitcher = defenceLineup.pitchers[0];

        self.storage.updateState({
            offence: offenceLineup.type,
            defence: defenceLineup.type,
            pitcher: currentPitcher.id
        });
    }

    function nextInning(){
        resetInningCounter();
        currentInning++;
        updateScoreUi(currentInning);
    }

    function updateHeader(){
        var side = '';
        if (offenceLineup.type == 'visitor')
            side = 'TOP';
        else
            side = 'BOTTOM';

        var ending = [0,'ST','ND','RD'];
        if (ending[currentInning])
            ending = ending[currentInning];
        else
            ending = 'TH';


        $('.js-header-second').text(side+' OF THE '+currentInning+ending+' / '+offenceLineup.name);
    }

    function updateInningTableHead(){
        var $heads = $('.ui-table-statistic-head-color');
        $heads.removeAttr('selected');
        if (offenceLineup.type == 'visitor')
            $heads.eq(0).attr('selected',1);
        else
            $heads.eq(1).attr('selected',1);
    }

    function updateInningBatterUi(){
        $('.js-lineup-batter').removeAttr('selected');
        $('.js-batting-batside').html();

        if (currentBatter) {
            $('.js-lineup-batter[batter=' + currentBatter.batter + ']', $offenceLineup).attr('selected', 1);
            $('.js-label-atbat').text(currentBatter.name);
            if (nextBatter == null)
                $('.js-label-ondeck').text('');
            else
                $('.js-label-ondeck').text(nextBatter.name);

            if (currentBatter.bats == 'R') {
                $('.js-batting-batside').html('<span class="ui-triangle" type="left"></span>BATTING LEFT');
            }
            if (currentBatter.bats == 'L') {
                $('.js-batting-batside').html('BATTING RIGHT<span class="ui-triangle" type="right"></span>');
            }
        }
    }

    function updateScoreUi(inning){
        $('.js-inning-visitor').eq(inning-1).text(inningCounter.visitor);
        $('.js-inning-home').eq(inning-1).text(inningCounter.home);
        $('.js-inning-visitor-r').text(inningTotal.visitor.R);
        $('.js-inning-visitor-h').text(inningTotal.visitor.H);
        $('.js-inning-visitor-e').text(inningTotal.visitor.E);
        $('.js-inning-home-r').text(inningTotal.home.R);
        $('.js-inning-home-h').text(inningTotal.home.H);
        $('.js-inning-home-e').text(inningTotal.home.E);
    }

    function getWinner(){
        if (offenceLineup.type == 'visitor' && inningTotal.visitor.R < inningTotal.home.R){
            return 'home';
        }
        if (offenceLineup.type == 'home'){
            if (inningTotal.visitor.R < inningTotal.home.R){
                return 'home';
            }
            if (inningTotal.visitor.R > inningTotal.home.R){
                return 'visitor';
            }
            if (inningTotal.visitor.R == inningTotal.home.R){
                return 'deadheat';
            }
        }

        return null;
    }

    function checkGameEndCondition(){
        if (currentInning == 9){
            winner = getWinner();
            return !!winner;
        }
        return false;
    }

    function nextGameSet(){
        if (winner)
            return;

        self.addPitchScore('IP');

        if (checkGameEndCondition()){
            self.endGame();
            return;
        }

        if (offenceLineup.type == 'home'){
            self.storage.nextInning();

            nextInning();
        }
        switchLineups();
        self.onNextGameSet();

        var batterNumber = nextBatter.batter;
        setCurrentBatter(lastBatterNumber);
        lastBatterNumber = batterNumber;

        self.storage.updateState({lastBatterNumber:lastBatterNumber});

        self.onBatterReady(currentBatter);
        updateHeader();
        updateInningTableHead();
    }

    self.storage = null;

    self.onBatterReady = function(){
    };

    self.onNextGameSet = function(){
    };

    self.onGameEnd = function(){
    };



    self.addInningRunScore = function(){
        var lineupType = offenceLineup.type;
        inningCounter[lineupType]++;
        inningTotal[lineupType].R++;

        self.storage.addInningScore(lineupType,'R');

        updateScoreUi(currentInning);
    };

    self.addInningHitScore = function(){
        var lineupType = offenceLineup.type;
        inningTotal[lineupType].H++;

        self.storage.addInningScore(lineupType,'H');

        updateScoreUi(currentInning);
    };

    self.addInningErrorScore = function(){
        var lineupType = defenceLineup.type;
        inningTotal[lineupType].E++;

        self.storage.addInningScore(lineupType,'E');

        updateScoreUi(currentInning);
    };

    self.addBothScore = function(scoretype){
        self.addBatterScore(scoretype);
        self.addPitchScore(scoretype);
    };

    self.addBatterScore = function(batter, scoretype){
        if (typeof batter == 'string'){
            scoretype = batter;
            batter = currentBatter;
        }
        addScore(batter, 'batters', scoretype);
    };

    self.addPitchScore = function(scoretype){
        addScore(currentPitcher, 'pitchers', scoretype);
    };

    self.tryDoNextGameSet = function(){
        if (outs3) {
            outs3 = false;
            self.storage.nextState();
            nextGameSet();
            return true;
        }
        return false;
    };

    self.nextBatter = function(){
        if (winner)
            return;

        if (!self.tryDoNextGameSet()){
            self.storage.nextState();
            setCurrentBatter(nextBatter.batter);
            self.onBatterReady(currentBatter);
        }

    };

    self.getGameSet = function(){
        return {
            defenceLineup: defenceLineup,
            offenceLineup: offenceLineup
        };
    };

    self.do3Outs = function(){
        outs3 = true;
    };

    self.startGame = function(){
        if (gameStarted)
            location.reload(); // TODO: Replace from here

        currentInning = 1;

        initLineups();
        initScoring();
        updateHeader();
        updateInningTableHead();
        self.onNextGameSet();

        resetInningCounter();
        updateScoreUi(currentInning);


        setCurrentBatter(1);
        self.onBatterReady(currentBatter);

        gameStarted = true;
    };

    self.endGame = function(status){
        currentBatter = null;
        updateInningBatterUi();

        status = status || 2;
        self.onGameEnd(status,getWinner());
    };

    self.restore = function(){
        currentInning = self.storage.currentInning + 1;

        initLineups();
        initScoring();
        restoreScoring();
        updateHeader();
        updateInningTableHead();

        restoreInningCounters();
        restoreCurrentBatter();
        restoreLastBatter();

        gameStarted = true;
    };

    return self;
}