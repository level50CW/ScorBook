function FieldController(){
    var self = this;

    var positions = {
        'P': {top: 138, left: 338},
        'C': {top: 232, left: 338},
        '1B': {top: 122, left: 528},
        '2B': {top: 106, left: 432},
        '3B': {top: 122, left: 152},
        'SS': {top: 106, left: 246},
        'LF': {top: 78, left: 164},
        'CF': {top: 62, left: 338},
        'RF': {top: 78, left: 520},
        'B': [
            {top: 212, left: 338},
            {top: 130, left: 494},
            {top: 90, left: 338},
            {top: 130, left: 184}
        ],


        getFielder: function(offset, position){

            return {
                top: offset.top+this[position].top-20,
                left: offset.left+this[position].left
            };
        },

        getBatter: function(offset, base){

            return {
                top: offset.top+this.B[base].top-20,
                left: offset.left+this.B[base].left
            };
        }
    };

    var currentRunners,
        currentGameSet,
        lastMarkRotateBatters,
        advancedBatters;

    resetGlobals();
    function resetGlobals(){
        currentRunners = null; // state
        currentGameSet = null; // state
        lastMarkRotateBatters = [];
        advancedBatters = [];

        var $field = $('.js-field');
        $field.children('.ui-circle[batter]').remove();
        $field.children('.ui-circle[fielder]').remove();
    }

    function getBatterByPosition(pos){
        return currentGameSet.offenceLineup.batters[pos-1];
    }

    function updateBatters(){
        var $field = $('.js-field');
        $field.children('.ui-circle[batter]').remove();
        var offset = $field.offset();
        for(var bi in currentRunners){
            var batter = getBatterByPosition(currentRunners[bi]);
            if (batter)
                $('<div class="ui-field-element ui-circle" hastext="1">')
                    .attr('batter',batter.number)
                    .attr('team',currentGameSet.offenceLineup.type)
                    .attr('position',bi)
                    .text(batter.number)
                    .appendTo($field)
                    .offset(positions.getBatter(offset, bi));
        }
    }

    function updateFielders(lineup){
        var $field = $('.js-field');
        $field.children('.ui-circle[fielder]').remove();
        var offset = $field.offset();
        for(var bi in lineup.fielders){
            var batter = lineup.fielders[bi];
            if (positions[batter.position]) {
                $('<div class="ui-field-element ui-circle" hastext="1">')
                    .attr('fielder',batter.number)
                    .attr('team',currentGameSet.defenceLineup.type)
                    .attr('position',batter.positionId)
                    .text(batter.number)
                    .appendTo($field)
                    .offset(positions.getFielder(offset, batter.position));
            }
        }
    }

    function updateFieldersClick(){
        $('div[fielder]', '.js-field').off().on('click',function() {
            var $this = $(this);
            self.onBatterFielderClick({
                type: 'fielder',
                number: +$this.attr('fielder'),
                team: currentGameSet.defenceLineup.type,
                position: +$this.attr('position'),
                object: $this
            });
        });

    }

    function updateBattersClick(){
        $('div[batter]', '.js-field').off().on('click', function() {
            var $this = $(this);
            self.onBatterFielderClick({
                type: 'batter',
                number: +$this.attr('batter'),
                team: currentGameSet.offenceLineup.type,
                position: +$this.attr('position'),
                object: $this
            });

            if (!!$this.attr('advancedBy')) {
                advancedBatters.push({
                    batter: +$this.text(),
                    advancedBy: +$this.attr('advancedBy')
                });
            }else{
                advancedBatters = _.reject(advancedBatters, function(x){return x.batter == +$this.text()});
            }

        });
    }

    function markRotateBatters(toBase, fromBase){
        toBase = toBase || 1;
        fromBase = fromBase || 0;
        var bases = currentRunners.map(function(x){return x? true: false});
        var moves = [];

        function _rec(base){
            if (bases[base]){
                _rec(base+1);
                moves.push(base);
                if (base<3)
                    bases[base+1] = true;
                bases[base] = false;
            }
        }

        for(var i = fromBase; i < toBase; i++)
            _rec(i);

        return moves;
    }

    function rotateBatters(moves){
        var runs = [];

        for(var i in moves){
            var base = moves[i];
            if (currentRunners[base]) {
                if (base < 3)
                    currentRunners[base + 1] = currentRunners[base];
                else
                    self.onAddInningScore(getBatterByPosition(currentRunners[3]));
                runs.push(base);
                self.onBatterRun(base);
                currentRunners[base] = null;
            }
        }

        self.storeBaseState(runs);
    }

    function rotateBattersForce(fromBaseEnd, fromBaseStart){
        var runs = [];
        fromBaseEnd = fromBaseEnd || 3;
        fromBaseStart = fromBaseStart || 0;

        for(var base=fromBaseEnd; base>=fromBaseStart; base--) {
            if (currentRunners[base]) {
                if (base<3)
                    currentRunners[base + 1] = currentRunners[base];
                else
                    self.onAddInningScore(getBatterByPosition(currentRunners[3]));
                runs.push(base);
                self.onBatterRun(base);
                currentRunners[base] = null;
            }
        }

        self.storeBaseState(runs);
    }

    function restoreBatters(){
        var state = self.storage.getState();
        var base = self.storage.getBaseState();
        currentRunners = [];
        if (base){
            for(var b in base.bases){
                var batterPosition = base.bases[b];
                if (batterPosition){
                    currentRunners[b] = batterPosition;
                }
            }
        }
        currentRunners[0] = state.batter;
        updateFielders(currentGameSet.defenceLineup);
        updateFieldersClick();
        self.updateBatters();
    }

    self.storage = null;
    self.players = null;

    self.onAddInningScore = function(batter){
    };

    self.onBatterRun = function(base){
    };

    self.onBatterFielderClick = function(obj){
        //    type: 'batter'/'fielder',
        //    number: +$this.attr('batter'),
        //    team: currentGameSet.offenceLineup.type,currentGameSet.defenceLineup.type
        //    position: +$this.attr('position')
        //    object: $this
    };

    self.clear = function(){
        var $field = $('.js-field');
        $field.children('.ui-circle[batter]').remove();
        $field.children('.ui-circle[fielder]').remove();
    };

    self.clearMarks = function(){
        $('.js-field').children('.ui-circle')
            .removeAttr('error')
            .removeAttr('advanced')
            .removeAttr('advancedBy');
        advancedBatters = [];
    };

    self.storeBaseState = function(runs){
        self.storage.addBaseState({
            bases: currentRunners.map(function(batter){ return (batter)? batter: null;}),
            runs: runs
        });
    };

    self.setGameSet = function(gameSet){
        currentGameSet = gameSet;
    };

    self.resetFielders = function(){
        $('.js-field').children('.ui-circle').remove();
        self.updateFielders();

        currentRunners = [];
        self.updateBatters();

        self.storeBaseState([]);
    };

    self.doBatterOut = function(){
        currentRunners[0] = null;
    };

    self.doBattersOut = function(batters){
        for(var b in batters){
            currentRunners[batters[b]] = null;
        }
    };

    self.updateFielders = function(){
        updateFielders(currentGameSet.defenceLineup);
        updateFieldersClick();
    };

    self.updateBatters = function(){
        updateBatters();
        updateBattersClick();
    };

    self.updateLineup = function(){
        $('.js-field').children('.ui-circle').remove();
        self.updateFielders();
        self.updateBatters();
    };

    self.markBatterBase = function(toBase, fromBase){
        lastMarkRotateBatters = markRotateBatters(toBase, fromBase);
    };

    self.doBatterBase = function(){
        rotateBatters(lastMarkRotateBatters);
        lastMarkRotateBatters = [];
        self.updateBatters();
    };

    self.doAutoBatterBase = function(toBase, fromBase){
        self.markBatterBase(toBase, fromBase);
        self.doBatterBase();
    };

    self.doBatterBaseForce = function(fromBaseEnd, fromBaseStart){
        rotateBattersForce(fromBaseEnd, fromBaseStart);
        self.updateBatters();
    };

    self.doAdvancedBatterBase = function(){
        $('.js-field').children('.ui-circle[batter]').each(function(){
            var $this = $(this);
            var id = _.findIndex(advancedBatters, function(x){return x.batter == +$this.text()});
            if (id > -1){
                var position = +$this.attr('position');
                var advancedBy = advancedBatters[id].advancedBy;
                self.doAutoBatterBase(Math.min(position+advancedBy,4),position);
            }
        });
    };

    self.doBatterHit = function(type){
        switch (type){
            case '1B':
                self.doAutoBatterBase();
                break;
            case '2B':
                self.doAutoBatterBase(2);
                break;
            case '3B':
                self.doAutoBatterBase(3);
                break;
            case 'HR':
                self.doAutoBatterBase(4);
                break;
        }
    };

    self.setCurrentBatter = function(batter){
        currentRunners[0] = batter.batter;
        self.updateBatters();
    };

    self.restore = function(gameSet){
        resetGlobals();
        currentGameSet = gameSet;
        restoreBatters();
    };

    return self;
}