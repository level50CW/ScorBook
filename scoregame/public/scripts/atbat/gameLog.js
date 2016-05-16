function GameLogController(){
    /* Page item id:
    0 - team
    0-100 - pitchers
    (p+1)*100 - player
     (p+1)*100+i - item
     (p+1)*100+50+pt - pitcher
     */

    var self = this;

    var $container = $('.js-container-pitch-list');
    var $list = $('.js-pitch-list');
    var $controls = $('.js-pitch-list-controls');
    var $pagePrevious = $controls.find('.js-left');
    var $pageNext = $controls.find('.js-right');
    var $counter = $controls.find('.js-counter');
    var scrollBar = $('.js-container-scrollbar').jScrollPane().data('jsp');


    var pitchPaterns = {
        strike: '<span>STRIKE</span><div class="ui-circle" color="blue">',
        ball: '<span>BALL</span><div class="ui-circle" color="green">',
        foul: '<span>FOUL</span><div class="ui-circle" color="gray">',
        hit: '<span></span><div class="ui-circle" color="yellow">',
        out: '<span></span><div class="ui-circle" color="red">',
        empty: '<span></span>',
        player: '<span></span>',
        pitcher: '<span></span>',
        team: '<span></span>'
    };

    var log,
        logLastPage,
        logCurrentPage,
        lastTeam,
        lastBatter,
        counter,
        pitcherItems;

    resetGlobals();
    function resetGlobals(){
        log = {
            page:{}
        };
        logLastPage = -1;
        logCurrentPage = 0;
        lastTeam = '';
        lastBatter = -1;
        counter = {
            player: 0,
            item: 0,
            pitcher:0
        };
        pitcherItems = {};

        $container.hide();
    }

    function createItem(type, text){
        var $item = $('<div class="ui-pitch-status-part" type="'+type+'">');
        $item.append(pitchPaterns[type]);
        if (text)
            $item.children('span').text(text);
        return $item;
    }

    function restore(){
        resetGlobals();

        self.storage.forEach(['inning', 'state', 'pitch'],{
            state: function(o){
                var state = o.state;

                if (!state.offence || !state.batter || state.pitches.length == 0)
                    o.abort = true;
            },
            pitch: function(o){
                var pitch = o.pitch;
                var state = o.state;

                if (!pitch.type)
                    return;

                var lineup = self.players.getInningLineup(state.offence, o.i+1);
                var batter = self.players.getPlayer(pitch.batter,'batters');
                var pitcher = self.players.getPlayer(pitch.pitcher,'pitchers');

                if (lineup.name != lastTeam) {
                    lastTeam = lineup.name;
                    self.createTeam(lastTeam);
                }

                if (batter.name != lastBatter) {
                    lastBatter = batter.name;
                    self.createPlayer(lastBatter);
                }

                counter.item++;
                var itemPos = counter.player * 100 + counter.item;

                if (pitch.type == 'strike' || pitch.type == 'ball' || pitch.type == 'foul')
                    addItem(pitch.type, null, itemPos);
                else
                    addItem(pitch.type, pitch.type.toUpperCase()+'-'+pitch.type2, itemPos);

                addPitchCount(pitcher);
            }
        });

    }

    function setPage(page){
        if (page>logLastPage)
            return;

        if (page<0)
            return;

        $container.show();
        $list.children().remove();
        log.page[page] = log.page[page] || [];
        var sorted = [];

        for(var i in log.page[page]){
            sorted.push(log.page[page][i]);
        }

        sorted = sorted.sort(function (a,b){
            return a.attr("position")-b.attr("position");
        });

        for(var i=0; i<sorted.length; i++){
            $list.append(sorted[i]);
        }

        logCurrentPage = page;
        $counter.text((logCurrentPage+1)+'/'+(logLastPage+1));
        scrollBar.reinitialise();
    }

    function addItem(type, text, position){
        log.page[logLastPage] = log.page[logLastPage] || [];
        var item = createItem(type, text);
        item.attr("position",position);
        log.page[logLastPage].push(item);
        return item;
    }

    function addPitchCount(pitcher){
        var itemPos;
        var name = pitcher.number+' '+pitcher.lineupName;
        if (!pitcherItems[name]){
            counter.pitcher++;
            itemPos = counter.pitcher;
            pitcherItems[name] = {
                count: 0,
                $item: addItem('pitcher','', itemPos),
                player: {}
            };
        }

        if (!pitcherItems[name].player[counter.player]){
            itemPos = counter.player*100+50+counter.pitcher;
            pitcherItems[name].player[counter.player] = {
                count: 0,
                $item: addItem('pitcher','', itemPos)
            };
        }

        var val = ++pitcherItems[name].count;
        pitcherItems[name].$item.children('span').text("PC - "+name+" - "+val);
        val = ++pitcherItems[name].player[counter.player].count;
        pitcherItems[name].player[counter.player].$item.children('span').text("PC - "+name+" - "+val);
    }

    $pagePrevious.click(function(){
        setPage(logCurrentPage-1);
    });

    $pageNext.click(function(){
        setPage(logCurrentPage+1);
    });

    /** @type PlayerController */
    self.players = null;
    /** @type StorageController */
    self.storage = null;

    // TODO: Replace with PlayerController
    self.onGetCurrentTeamBatter = function(){};

    self.restore = function(){
        resetGlobals();
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

        counter.item++;
        var itemPos = counter.player * 100 + counter.item;

        if (type == 'strike' || type == 'ball' || type == 'foul') {
            addItem(type, null, itemPos);
        } else {
            addItem(type, type.toUpperCase() + '-' + text, itemPos);
        }
    };

    self.addPitchCount = function(){
        var pitch = self.storage.getPitch();
        var pitcher = self.players.getPlayer(pitch.pitcher,'pitchers');
        addPitchCount(pitcher);
    };

    self.createPlayer = function(name){
        counter.player++;
        counter.item = 0;
        addItem('player', name, counter.player*100);
    };

    self.createTeam = function(name){
        logLastPage++;

        counter.player = 0;
        counter.item = 0;
        counter.pitcher = 0;
        pitcherItems = {};

        addItem('team', name,0);

        if (logLastPage-1 == logCurrentPage)
            setPage(logLastPage)
    };

    self.update = function(){
        setPage(logCurrentPage);
    };
}