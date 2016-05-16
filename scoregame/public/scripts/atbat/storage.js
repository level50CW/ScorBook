function StorageController(){
    var self = this;

    function getStateObject(){
        if (!self.innings[self.currentInning]) {
            self.innings[self.currentInning] = {};
            self.innings[self.currentInning].state = [];
            self.innings[self.currentInning].bases = [];
        }

        if (!self.innings[self.currentInning].state[self.currentState]) {
            self.innings[self.currentInning].state[self.currentState] = {};
            self.innings[self.currentInning].state[self.currentState].pitches = [];
            self.innings[self.currentInning].state[self.currentState].playerScores = [];
            self.innings[self.currentInning].state[self.currentState].inningScores = [];
        }

        return self.innings[self.currentInning].state[self.currentState];
    }

    function getPitchObject(){
        var state = getStateObject();
        if (!state.pitches[self.currentPitch] && self.currentPitch >= 0){
            state.pitches[self.currentPitch] = {};
        }

        return state.pitches[self.currentPitch];
    }

    function getBaseState(i,s,p){
        for (var b = self.innings[i].bases.length-1; b>=0; b--){
            var base = self.innings[i].bases[b];
            if (base.id<=s*100+p){
                return self.innings[i].bases.filter(function(e){return e.id == base.id;});
            }
        }
        return null;
    }

    self.currentInning = 0;
    self.currentState = 0;
    self.currentPitch = -1;

    self.innings = [];

    self.request = null;


    self.onUpdatePitch = function(){};
    self.onUpdateState = function(){};

    self.getInning = function(){
        getStateObject();
        return self.innings[self.currentInning];
    };

    self.getState = function(){
        return getStateObject();
    };

    self.getPitch = function(){
        return getPitchObject();
    };

    self.register = function(controller){
        controller.storage = self;
    };

    self.addPlayerScore = function(id,playerType,scoreType){
        self.onUpdatePitch();
        var scores = getStateObject().playerScores;
        scores.push({
            id:id,
            type:playerType,
            score:scoreType,
            pitch: self.currentPitch
        });
    };

    self.addBaseState = function(obj){
        self.innings[self.currentInning].bases.push($.extend(true,{
            id: self.currentState*100+self.currentPitch
        }, obj));
    };

    self.getBaseState = function(){
        var arr = getBaseState(self.currentInning,self.currentState,self.currentPitch);
        return arr? arr[arr.length - 1] : null;
    };

    self.addInningScore = function(teamType,scoreType){
        self.onUpdatePitch();
        var scores = getStateObject().inningScores;
        scores.push({
            pitch: self.currentPitch,
            type:teamType,
            score:scoreType
        });
    };

    self.updateState = function(obj){
        self.onUpdateState();
        var state = getStateObject();
        $.extend(true,state,obj);
    };

    self.updatePitch = function(obj){
        self.onUpdatePitch();
        var pitch = getPitchObject();
        $.extend(true,pitch,obj);
    };

    self.newPitch = function(){
        self.currentPitch++;
    };

    self.nextState = function(){
        var previous = getStateObject();
        var previousPitch = getPitchObject();

        self.currentState++;


        self.currentPitch = -1;
        var current = getStateObject();

        current.offence = previous.offence;
        current.defence = previous.defence;
        current.pitcher = previous.pitcher;

        current.outs = previous.outs;
        if (previousPitch && previousPitch.counter){
            current.outs = previousPitch.counter.out;
        }

        current.outs = current.outs >= 3? 0 : (current.outs || 0);
    };

    self.nextInning = function(){
        self.currentPitch = -1;
        self.currentState = 0;
        self.currentInning++;

        self.request.setGameInning(self.currentInning);
    };

    self.undoBy = function(type){

        function predicate(x){
            return x.pitch <= self.currentPitch;
        }

        function predicateBases(x) {
            return x.id < self.currentState * 100 + self.currentPitch || x.id == -1;
        }

        switch(type){
            case 'pitch':
                if (self.currentPitch == -1)
                {
                    if (self.currentState == 0 && self.currentInning == 0)
                        return;

                    self.undoBy('state');
                    // length - 1 because -1 means L-1 point: 0 is before 1, -1 is before 0, L-1 is before 0, L-2 is before L-1
                    // Data:    18, 19, 0,  1,  2,   0,     0
                    // Before:  17, 18, -1, 0,  1,   -1,    -1
                    self.currentPitch = self.innings[self.currentInning].state[self.currentState].pitches.length - 1;
                }

                if (self.currentPitch > -1) {
                    self.currentPitch--;
                    self.innings[self.currentInning].state[self.currentState].pitches.pop();
                }

                self.innings[self.currentInning].state[self.currentState].playerScores =
                    self.innings[self.currentInning].state[self.currentState].playerScores.filter(predicate);
                self.innings[self.currentInning].state[self.currentState].inningScores =
                    self.innings[self.currentInning].state[self.currentState].inningScores.filter(predicate);
                self.innings[self.currentInning].bases =
                    self.innings[self.currentInning].bases.filter(predicateBases);

                console.log('Storage: ',self.currentInning,self.currentState,self.currentPitch);

                return;
            case 'state':
                if (self.currentState == 0)
                {
                    if (self.currentInning == 0)
                        return;

                    self.undoBy('inning');
                    // TODO: There is 1 redundant state (inning.js: 422, 335)
                    self.currentState = self.innings[self.currentInning].state.length - 1;
                }

                if (self.currentState>0) {
                    self.currentState--;
                    self.currentPitch = -1;
                    self.innings[self.currentInning].state.pop();
                }

                return;
            case 'inning':
                if (self.currentInning > 0) {
                    self.currentInning--;
                    self.currentState = 0;
                    self.currentPitch = -1;

                    self.innings.pop();

                    self.request.setGameInning(self.currentInning);
                }

                return;
        }
    };

    /**
     *
     * @param types ['inning', 'state', 'pitch']
     * @param callbacks Object as
     *                  {pitch: function,
     *                  state: function,
     *                  stateAfter: function,
     *                  inning: function,
     *                  inningAfter: function}
     *                  function is {
                            i: number,
                            s: number,
                            p: number,
                            inning: object,
                            state: object,
                            pitch: object,
                            base: object,
                            abort: false
                        }

     var base = o.base;
     var pitch = o.pitch;
     var state = o.state;
     var inning = o.inning;


     */
    self.forEach = function(types,callbacks){
        callbacks.pitch = callbacks.pitch || function(){};
        callbacks.state = callbacks.state || function(){};
        callbacks.stateAfter = callbacks.stateAfter || function(){};
        callbacks.inning = callbacks.inning || function(){};
        callbacks.inningAfter = callbacks.inningAfter || function(){};

        var currentId = self.currentInning*1000000 + self.currentState*1000 + self.currentPitch;

        function eachInning(currentFunc, breakPredicate, isCurrent, innerCallback){
            if (isCurrent){
                innerCallback(currentFunc());
                return;
            }

            for(var k = 0; breakPredicate(k); k++){
                innerCallback(k);
            }
        }

        eachInning(
            function(){return self.currentInning},
            function(k){ return k*1000000<=currentId && k<self.innings.length;},
            types.indexOf('inning') == -1, function(i){

            var obj = {
                i: i,
                inning: self.innings[i],
                abort: false
            };
            callbacks.inning(obj);

            if (obj.abort)
                return;


            eachInning(
                function(){return self.currentState},
                function(k){ return i*1000000+k*1000<=currentId && k<self.innings[i].state.length;},
                types.indexOf('state') == -1, function(s){

                obj = {
                    i: i,
                    s: s,
                    inning: self.innings[i],
                    state: self.innings[i].state[s],
                    abort: false
                };

                callbacks.state(obj);

                if (obj.abort)
                    return;

                eachInning(
                    function(){return self.currentPitch},
                    function(k){ return i*1000000+s*1000+k<=currentId && k<self.innings[i].state[s].pitches.length;},
                    types.indexOf('pitch') == -1, function(p){
                    callbacks.pitch({
                        i: i,
                        s: s,
                        p: p,
                        inning: self.innings[i],
                        state: self.innings[i].state[s],
                        pitch: self.innings[i].state[s].pitches[p],
                        base: getBaseState(i,s,p)
                    });
                });

                callbacks.stateAfter({
                    i: i,
                    s: s,
                    inning: self.innings[i],
                    state: self.innings[i].state[s]
                });

            });

            callbacks.inningAfter({
                i: i,
                inning: self.innings[i]
            });
        });
    };

    self.setData = function(obj){
        self.innings = obj.innings;
        self.currentInning = obj.currentInning;
        self.currentPitch = obj.currentPitch;
        self.currentState = obj.currentState;
    };

    self.getData = function(){
        return {
            innings: self.innings,
            currentInning: self.currentInning,
            currentPitch: self.currentPitch,
            currentState: self.currentState
        }
    };

    self.storeState = function(callback){
        self.request.setStorage(self.getData(),callback);
    };

    self.restoreState = function(callback){
        self.request.getStorage(function(data){
            self.setData(data);
            callback();
        });
    };
}