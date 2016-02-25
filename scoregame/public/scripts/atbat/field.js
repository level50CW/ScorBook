function FieldController(){
    var self = this;

    var positions = {
        'P': {top: 98, left: 196},
        'C': {top: 163, left: 196},
        '1B': {top: 82, left: 298},
        '2B': {top: 71, left: 256},
        '3B': {top: 82, left: 100},
        'SS': {top: 71, left: 140},
        'LF': {top: 56, left: 89},
        'CF': {top: 45, left: 196},
        'RF': {top: 56, left: 322},
        'B': [
            {top: 142, left: 196},
            {top: 96, left: 298},
            {top: 67, left: 196},
            {top: 96, left: 100}
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

    var currentBatters = null; // state
    var currentGameSet = null; // state
    var lastMarkRotateBatters = [];
    var advancedBatters = [];

    function updateBatters(){
        var $field = $('.js-field');
        $field.children('.ui-circle[batter]').remove();
        var offset = $field.offset();
        for(var bi in currentBatters){
            var batter = currentBatters[bi];
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
        var bases = currentBatters.map(function(x){return x? true: false});
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
            if (currentBatters[base]) {
                if (base < 3)
                    currentBatters[base + 1] = currentBatters[base];
                else
                    self.onAddInningScore(currentBatters[3]);
                runs.push(base);
                self.onBatterRun(base);
                currentBatters[base] = null;
            }
        }

        self.storeBaseState(runs);
    }

    function rotateBattersForce(fromBaseEnd, fromBaseStart){
        var runs = [];
        fromBaseEnd = fromBaseEnd || 3;
        fromBaseStart = fromBaseStart || 0;

        for(var base=fromBaseEnd; base>=fromBaseStart; base--) {
            if (currentBatters[base]) {
                if (base<3)
                    currentBatters[base + 1] = currentBatters[base];
                else
                    self.onAddInningScore(currentBatters[3]);
                runs.push(base);
                self.onBatterRun(base);
                currentBatters[base] = null;
            }
        }

        self.storeBaseState(runs);
    }

    function restoreBatters(){
        var state = self.storage.getState();
        var base = self.storage.getBaseState();
        currentBatters = [];
        if (base){
            for(var b in base.bases){
                var batterId = base.bases[b];
                if (batterId){
                    currentBatters[b] = currentGameSet.offenceLineup.getPlayer(batterId, 'batters');
                }
            }
        }
        currentBatters[0] = currentGameSet.offenceLineup.batters[state.batter-1];
        updateFielders(currentGameSet.defenceLineup);
        updateFieldersClick();
        self.updateBatters();
    }

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
            bases: currentBatters.map(function(batter){ return (batter)? batter.id: null;}),
            runs: runs
        });
    };

    self.setGameSet = function(gameSet){
        currentGameSet = gameSet;
    };

    self.resetFielders = function(){
        $('.js-field').children('.ui-circle').remove();
        updateFielders(currentGameSet.defenceLineup);
        updateFieldersClick();

        currentBatters = [];
        self.updateBatters();

        self.storeBaseState([]);
    };

    self.doBatterOut = function(){
        currentBatters[0] = null;
    };

    self.doBattersOut = function(batters){
        for(var b in batters){
            currentBatters[batters[b]] = null;
        }
    };

    self.updateBatters = function(){
        updateBatters();
        updateBattersClick();
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
        currentBatters[0] = batter;
        self.updateBatters();
    };

    self.restore = function(){
        restoreBatters();
    };

    return self;
}