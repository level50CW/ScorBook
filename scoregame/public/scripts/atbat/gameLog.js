function GameLogController(){
    var self = this;
    var $container = $('.js-container-pitch-list');
    var $list = $('.js-pitch-list');
    var $controls = $('.js-pitch-list-controls');
    var $pagePrevious = $controls.find('.js-left');
    var $pageNext = $controls.find('.js-right');
    var $counter = $controls.find('.js-counter');

    var log = {
        page:{}
    };
    var logLastPage = -1;
    var logCurrentPage = 0;
    var lastTeam = '';
    var lastBatter = -1;

    var pitchPaterns = {
        strike: '<span>STRIKE</span><div class="ui-circle" color="blue">',
        ball: '<span>BALL</span><div class="ui-circle" color="green">',
        hit: '<span></span><div class="ui-circle" color="yellow">',
        out: '<span></span><div class="ui-circle" color="red">',
        empty: '<span></span>',
        player: '<span></span>',
        team: '<span></span>'
    };

    function createItem(type, text){
        var $item = $('<div class="ui-pitch-status-part" type="'+type+'">');
        $item.append(pitchPaterns[type]);
        if (text)
            $item.children('span').text(text);
        return $item;
    }

    function restore(){
        for (var i in self.storage.innings) {
            for (var s in self.storage.innings[i].state) {
                var state = self.storage.innings[i].state[s];

                if (!state.offence || !state.batter || state.pitches.length == 0)
                    continue;

                for (var p in state.pitches) {
                    var pitch = state.pitches[p];

                    if (!pitch.type)
                        continue;

                    if (G.lineups[state.offence].name != lastTeam) {
                        lastTeam = G.lineups[state.offence].name;
                        self.createTeam(lastTeam);
                    }

                    if (G.lineups[state.offence].batters[state.batter-1].name != lastBatter) {
                        lastBatter = G.lineups[state.offence].batters[state.batter-1].name;
                        self.createPlayer(lastBatter);
                    }

                    if (pitch.type == 'strike' || pitch.type == 'ball')
                        addItem(pitch.type);
                    else
                        addItem(pitch.type, pitch.type.toUpperCase()+'-'+pitch.type2);
                }
            }
        }
    }

    function setPage(page){
        if (page>logLastPage)
            return;

        if (page<0)
            return;

        $container.show();
        $list.children().remove();
        log.page[page] = log.page[page] || [];
        for(var i in log.page[page]){
            $list.append(log.page[page][i]);
        }

        logCurrentPage = page;
        $counter.text((logCurrentPage+1)+'/'+(logLastPage+1));
    }

    function addItem(type, text){
        log.page[logLastPage] = log.page[logLastPage] || [];
        log.page[logLastPage].push(createItem(type, text));
    }

    $pagePrevious.click(function(){
        setPage(logCurrentPage-1);
    });

    $pageNext.click(function(){
        setPage(logCurrentPage+1);
    });

    self.onGetCurrentTeamBatter = function(){};

    self.restore = function(){
        restore();
        setPage(logLastPage);
    };

    self.addItem = function(type, text){
        var current = self.onGetCurrentTeamBatter();
        if (current.lineup != lastTeam) {
            lastTeam = current.lineup;
            self.createTeam(lastTeam);
        }

        if (current.batter != lastBatter) {
            lastBatter = current.batter;
            self.createPlayer(lastBatter);
        }

        if (type == 'strike' || type == 'ball')
            addItem(type);
        else
            addItem(type, type.toUpperCase()+'-'+text);
    };

    self.createPlayer = function(name){
        addItem('player', name);
    };

    self.createTeam = function(name){
        logLastPage++;
        addItem('team', name);

        if (logLastPage-1 == logCurrentPage)
            setPage(logLastPage)
    };

    self.update = function(){
        setPage(logCurrentPage);
    };
}