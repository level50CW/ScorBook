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

    self.currentInning = 0;
    self.currentState = 0;
    self.currentPitch = -1;

    self.innings = [];

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
        var scores = getStateObject().playerScores;
        scores.push({
            id:id,
            type:playerType,
            score:scoreType
        });
    };

    self.addBaseState = function(obj){
        self.innings[self.currentInning].bases.push($.extend(true,{
            id: self.currentState*10+self.currentPitch
        }, obj));
    };

    self.getBaseState = function(){
        for (var b = self.innings[self.currentInning].bases.length-1; b>=0; b--){
            var base = self.innings[self.currentInning].bases[b];
            if (base.id<=self.currentState*10+self.currentPitch)
                return base;
        }
        return null;
    };

    self.addInningScore = function(teamType,scoreType){
        var scores = getStateObject().inningScores;
        scores.push({
            type:teamType,
            score:scoreType
        });
    };

    self.updateState = function(obj){
        var state = getStateObject();
        $.extend(true,state,obj);
    };

    self.updatePitch = function(obj){
        var pitch = getPitchObject();
        $.extend(true,pitch,obj);
    };

    self.newPitch = function(){
        self.currentPitch++;
    };

    self.nextState = function(){
        var previous = getStateObject();
        self.currentState++;
        self.currentPitch = -1;
        var current = getStateObject();

        current.offence = previous.offence;
        current.defence = previous.defence;
        current.pitcher = previous.pitcher;
        current.outs = previous.outs >= 3? 0 : (previous.outs || 0);
    };

    self.nextInning = function(){
        self.currentPitch = -1;
        self.currentState = 0;
        self.currentInning++;
    };
}