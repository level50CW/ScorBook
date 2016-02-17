function OutController(){
    var self = this;

    var $field = $('.js-field');
    var $fielders = $('div[fielder]', '.js-field');
    var outType;
    var isCoordinatesSet;
    var isEnabled;
    var selectedFielderPositions = [];
    var selectedBatterPositions = [];
    var selectionMode = null;
    var outTypePermission = {
        'FO':1,
        'GO':1,
        'SacF':1,
        'SacB':1,
        'DP':2,
        'TP':3
    };

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-outs',
            trigger: 'left',
            items:{
                'FO':{
                    name: 'Fly Out',
                    callback: menuHandle
                },
                'GO':{
                    name: 'Ground Out',
                    callback: menuHandle
                },
                'SacF':{
                    name: 'Sac Fly',
                    callback: menuHandle
                },
                'SacB':{
                    name: 'Sac Bunt',
                    callback: menuHandle
                },
                'DP':{
                    name: 'Double Play',
                    callback: menuHandle
                },
                'TP':{
                    name: 'Triple Play',
                    callback: menuHandle
                },
                'CS':{
                    name: 'Caught Stealing',
                    disabled: true
                },
                'PO':{
                    name: 'Picked Off Base',
                    disabled: true
                }
            }
        });

        self.enable(false);
    }

    function menuHandle(item){
        if (outTypePermission[item]>getAllowedOutType()){
            alert('You can not do this action. The action limited by number of saved bases or outs.');
            return;
        }

        if ((item == 'SacF' || item == 'SacB') && !isSacrificeAllowed()){
            alert('You can not do this action. There is no one to sacrifice for or the team has 2 outs.');
            return;
        }

        if (item == 'SacF' && !isSacrificeFlyAllowed()){
            alert('You can not do this action. There is no one at 3B.');
            return;
        }

        outType = item;
        $('.js-field').css('background-color','#222');
    }

    function getAllowedOutType(){
        var baseState = self.storage.getBaseState();
        var state = self.storage.getState();
        var filled = baseState.bases.filter(function(x){return x;}).length;
        return Math.min(filled + 1, 3 - (state.outs || 0));
    }

    function isSacrificeAllowed(){
        var baseState = self.storage.getBaseState();
        var state = self.storage.getState();
        var filled = baseState.bases.filter(function(x){return x;}).length;
        return filled > 0 && (state.outs || 0) < 2;
    }

    function isSacrificeFlyAllowed(){
        var baseState = self.storage.getBaseState();
        return !!baseState.bases[3];
    }

    $field.mousedown(function(e){
        if (isEnabled && outType && !isCoordinatesSet) {
            var fieldOffset = $field.offset();
            var coordinatesHit = {x: e.pageX - fieldOffset.left, y: e.pageY - fieldOffset.top};

            self.storage.updatePitch({
                type: 'out',
                type2: outType,
                coordinatesHit: coordinatesHit
            });

            self.onDrawHit(coordinatesHit);
            isCoordinatesSet = true;
            selectionMode = 'fielders';
            selectedFielderPositions = [];
            selectedBatterPositions = [];
        }
    });

    $field.mousemove(function(e){
        if (isEnabled && outType && !isCoordinatesSet) {
            var fieldOffset = $field.offset();
            self.onDrawHit({x: e.pageX - fieldOffset.left, y: e.pageY - fieldOffset.top});
        }
    });

    self.onOut = function(type, fielders, batters){};
    self.onDrawHit = function(point){};
    self.onBatterBase = function(){};

    self.enable = function(isEnable){
        isEnabled = isEnable;
        var button = $('.js-button-outs');
        button.contextMenu(isEnable);

        if (isEnable)
            button.removeAttr('disabled');
        else {
            button.attr('disabled', 1);

            outType = null;
            isCoordinatesSet = false;
            selectedFielderPositions = [];
        }
    };

    self.doClick = function(obj){
        if (isEnabled && outType && isCoordinatesSet && selectionMode != null){
            if (obj.type == 'fielder'){
                if (selectionMode == 'batters'){
                    alert('You should select batters');
                    return;
                }

                if (selectedFielderPositions.indexOf(obj.position) != -1)
                    return;

                if (selectedFielderPositions.length>=4){
                    alert('You have selected to much fielders');
                    return;
                }

                selectedFielderPositions.push(obj.position);

                if (outType == 'GO' && selectedFielderPositions[0] !=3 ){
                    selectedFielderPositions.push(3);
                }

                if (outType == 'SacF' ||
                    outType == 'SacB'){
                    self.onBatterBase();
                }

                if (    outType == 'FO' ||
                        outType == 'GO' ||
                        outType == 'SacF' ||
                        outType == 'SacB'){
                    isCoordinatesSet = false;
                    selectedBatterPositions.push(0); // current batter
                    self.onOut(outType, selectedFielderPositions, selectedBatterPositions);
                    outType = null;
                    self.enable(false);
                }
            }

            if (obj.type == 'batter'){
                if (selectedFielderPositions.length == 0){
                    alert('You should select fielders first');
                    return;
                }

                if (selectionMode == 'fielders') {
                    selectionMode = 'batters';
                    selectedBatterPositions = [];
                }

                //if (selectionMode == 'batters')  // always true
                if (selectedBatterPositions.indexOf(obj.position) != -1)
                    return;

                selectedBatterPositions.push(obj.position);

                if (selectedBatterPositions.length == outTypePermission[outType]){
                    isCoordinatesSet = false;
                    self.onOut(outType, selectedFielderPositions, selectedBatterPositions);
                    outType = null;
                    self.enable(false);
                }
            }
        }
    };

    initMenu();
}