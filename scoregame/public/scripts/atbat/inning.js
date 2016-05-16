function InningController(){
    var self = this;

    var $lineups,
        defenceLineup,
        offenceLineup,
        $defenceLineup,
        $offenceLineup;

    var gameStarted,

        currentPitcher,
        currentBatter,
        nextBatter,
        currentInning,
        winner,
        outs3,
        lastBatterNumber,

        inningCounter,

        inningTotal,

        scoring,
        $scoring,

        createNextState;

    resetGlobals();

    function resetGlobals(){
        gameStarted = false;

        currentPitcher = null; // state
        currentBatter = null; // state
        nextBatter = null; // state
        currentInning = 0; // 1-9 // state
        winner = null; // state
        outs3 = false;
        lastBatterNumber = 1;

        inningCounter = {
            visitor: 0,
            home: 0
        }; // state

        inningTotal = {
            visitor: {R: 0, H: 0, E: 0},
            home: {R: 0, H: 0, E: 0}
        }; // state

        scoring = null; // state
        $scoring = null;

        createNextState = false;
    }

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
            var batters = self.players.getPlayers(team,'batters');
            for(var pi in batters){
                var player = batters[pi];
                $scoring.batters[player.id] = $lineups[team].find('.js-lineup-batter[player='+player.id+']');
                $scoring.batters[player.id].children('td[type]').text(0);
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
            var pitchers = self.players.getPlayers(team,'pitchers');
            for(var pi in pitchers){
                var player = pitchers[pi];
                $scoring.pitchers[player.id] = $lineups[teamOpponent].find('.js-lineup-pitcher[player='+player.id+']');
                $scoring.pitchers[player.id].children('td[type]').text(0);
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
        self.storage.forEach(['inning', 'state'], {
            state: function(o){
                for(var sc in o.state.playerScores){
                    var score = o.state.playerScores[sc];
                    scoring[score.type][score.id] = scoring[score.type][score.id] || {};
                    scoring[score.type][score.id][score.score] = scoring[score.type][score.id][score.score] || 0;
                    scoring[score.type][score.id][score.score]++;
                }
            }
        });
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

        var lineups = {
            home: self.players.getInningLineup('home',currentInning),
            visitor: self.players.getInningLineup('visitor',currentInning)
        };

        var state = self.storage.getState();
        if (state.offence && state.defence){

            defenceLineup = lineups[state.defence];
            offenceLineup = lineups[state.offence];
            $defenceLineup = $lineups[state.defence];
            $offenceLineup = $lineups[state.offence];

            currentPitcher = defenceLineup.pitchers[0];

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
        self.storage.forEach(['inning', 'state'], {
            inning: function(o){
                inningCounter.visitor = 0;
                inningCounter.home = 0;
            },

            state: function(o){
                for (var sc in o.state.inningScores) {
                    var score = o.state.inningScores[sc];

                    if (score.score == 'R'){
                        inningCounter[score.type]++;
                    }
                    inningTotal[score.type][score.score]++;
                }
            },

            inningAfter: function(o){
                updateTeamScoreUi(o.i+1);
            }
        });
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

        self.storage.forEach(['state'], {
            state: function(o){
                if (o.state.lastBatterNumber){
                    lastBatterNumber = o.state.lastBatterNumber;
                }
            }
        });
    }

    function switchLineups(){

        self.storage.updateState({
            offence: defenceLineup.type,
            defence: offenceLineup.type
        });

        var buffer = self.players.getInningLineup(defenceLineup.type,currentInning);
        defenceLineup = self.players.getInningLineup(offenceLineup.type,currentInning);
        offenceLineup = buffer;
        buffer = $defenceLineup;
        $defenceLineup = $offenceLineup;
        $offenceLineup = buffer;

        currentPitcher = defenceLineup.pitchers[0];

        self.storage.updateState({
            pitcher: currentPitcher.id
        });
    }

    function nextInning(){
        resetInningCounter();
        currentInning++;
        updateTeamScoreUi(currentInning);
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
        $('.js-lineup-pitcher').removeAttr('selected');
        $('.js-batting-batside').html();

        if (currentBatter) {
            $('.js-lineup-batter[player=' + currentBatter.id + ']', $offenceLineup).attr('selected', 1);
            $('.js-lineup-pitcher[player=' + currentPitcher.id + ']', $offenceLineup).attr('selected', 1);

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

    function updateTeamScoreUi(inning){
        $('.js-inning-visitor').eq(inning-1).text(inningCounter.visitor);
        $('.js-inning-home').eq(inning-1).text(inningCounter.home);
        $('.js-inning-visitor-r').text(inningTotal.visitor.R);
        $('.js-inning-visitor-h').text(inningTotal.visitor.H);
        $('.js-inning-visitor-e').text(inningTotal.visitor.E);
        $('.js-inning-home-r').text(inningTotal.home.R);
        $('.js-inning-home-h').text(inningTotal.home.H);
        $('.js-inning-home-e').text(inningTotal.home.E);
    }

    function updateLineupScoreUi(){
        function _byPlayersType(players, type){
            for(var p in players){
                var player = players[p];
                var $tds = $scoring[type][player.id].children('td');
                var counter = 2;
                for (var s in scoring[type][player.id]){
                    if (s != 'player'){
                        $tds.eq(counter).text(scoring[type][player.id][s]);
                        counter++;
                    }
                }
            }
        }

        _byPlayersType(self.players.getPlayers('visitor','batters'),'batters');
        _byPlayersType(self.players.getPlayers('home','batters'),'batters');
        _byPlayersType(self.players.getPlayers('visitor','pitchers'),'pitchers');
        _byPlayersType(self.players.getPlayers('home','pitchers'),'pitchers');
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
            createNextState = false;

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
        updateLineupScoreUi();
    }

    /** @type PlayerController */
    self.players = null;
    /** @type StorageController */
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

        updateTeamScoreUi(currentInning);
    };

    self.addInningHitScore = function(){
        var lineupType = offenceLineup.type;
        inningTotal[lineupType].H++;

        self.storage.addInningScore(lineupType,'H');

        updateTeamScoreUi(currentInning);
    };

    self.addInningErrorScore = function(){
        var lineupType = defenceLineup.type;
        inningTotal[lineupType].E++;

        self.storage.addInningScore(lineupType,'E');

        updateTeamScoreUi(currentInning);
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
            //self.storage.nextState();
            nextGameSet();
            return true;
        }
        return false;
    };

    self.nextBatter = function(){
        if (winner)
            return;

        createNextState = true;
        if (!self.tryDoNextGameSet()){
            //self.storage.nextState();
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

    self.getCurrentBatter = function(){
        return currentBatter;
    };

    self.do3Outs = function(){
        outs3 = true;
    };

    self.updateLineup = function(){
        defenceLineup = self.players.getInningLineup(defenceLineup.type,currentInning);
        offenceLineup = self.players.getInningLineup(offenceLineup.type,currentInning);
        currentPitcher = defenceLineup.pitchers[0];

        self.storage.updateState({
            pitcher: currentPitcher.id
        });

        updateInningBatterUi();
        updateLineupScoreUi();
    };

    self.updatePitchActors = function(){
        self.storage.updatePitch({
            pitcher: currentPitcher.id,
            batter: currentBatter.id
        });
    };

    self.startGame = function(){
        if (gameStarted)
            location.reload(); // TODO: Replace from here

        currentInning = 1;

        initLineups();
        initScoring();
        updateHeader();
        updateInningTableHead();
        updateLineupScoreUi();
        self.onNextGameSet();

        resetInningCounter();
        updateTeamScoreUi(currentInning);


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
        resetGlobals();

        currentInning = self.storage.currentInning + 1;

        initLineups();
        initScoring();
        restoreScoring();
        updateHeader();
        updateInningTableHead();
        updateLineupScoreUi();

        restoreInningCounters();
        restoreCurrentBatter();
        restoreLastBatter();

        gameStarted = true;
    };

    self.tryCreateState = function(){
        if (createNextState){
            createNextState = false;
            self.storage.nextState();
        }
    };

    return self;
}