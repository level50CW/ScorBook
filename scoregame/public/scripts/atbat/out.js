function OutController(){
    var self = this;

    var $field = $('.js-field');
    var $fielders = $('div[fielder]', '.js-field');
    var outType;
    var isCoordinatesSet;
    var isEnabled;
    var selectedFielderPositions = [];
    var selectedBatterPositions = [];
    var ignoredBatters = [];
    var errorFielders = [];
    var selectionMode = null;
    var userShouldSelectType = false;
    var outTypePermission = {
        'F':1,
        'GO':1,
        'SacF':1,
        'SacB':1,
        'FO':1,
        'TO':1,
        'DP':2,
        'TP':3
    };

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-outs',
            trigger: 'left',
            items:{
                'F':{
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
                'FO':{
                    name: 'Force Out',
                    callback: menuHandle
                },
                'TO':{
                    name: 'Tag Out',
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
        if (userShouldSelectType){

            if (outTypePermission[item] != 1){
                alert('Please, select OUT type of 1 runner.');
                return;
            }

            userShouldSelectType = false;
            outType = item;
            endOutFinished();
            return;
        }

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

        if (item == 'FO' && !isForceOutAllowed()){
            alert('You can not do this action. There is no forced runner.');
            return;
        }

        outType = item;
        $('.js-field').css('background-color','#222');
    }

    function getBases(){
        var baseState = self.storage.getBaseState();
        return baseState.bases;
    }

    function getAllowedOutType(){
        var state = self.storage.getState();
        var filled = getBases().filter(function(x){return x;}).length;
        return Math.min(filled + 1, 3 - (state.outs || 0));
    }

    function isSacrificeAllowed(){
        var state = self.storage.getState();
        var filled = getBases().filter(function(x){return x;}).length;
        return filled > 0 && (state.outs || 0) < 2;
    }

    function isSacrificeFlyAllowed(){
        return !!getBases()[3];
    }

    function isForceOutAllowed(position){
        if (position == null)
            for(var i in getBases()){
                if (!!getBases()[i] && isForceOutAllowed(i))
                    return true;
            }

        return position>1 && !!getBases()[position-1] || position == 1;
    }

    function removeIgnored(){
        if (errorFielders.indexOf(selectedFielderPositions[0]) != -1 &&
            (outType == 'F' ||
            outType == 'SacF' ||
            outType == 'SacB')){
            selectedBatterPositions = _.without(selectedBatterPositions,0);
        }

        if (errorFielders.indexOf(selectedFielderPositions[1]) != -1 && outType == 'SacB')
            selectedBatterPositions = _.without(selectedBatterPositions,0);

        selectedBatterPositions = _.difference(selectedBatterPositions, ignoredBatters);
    }


    function endOut(){
        var outed = selectedBatterPositions.length;

        removeIgnored();

        if (outed != selectedBatterPositions.length){

            if (selectedBatterPositions.length == 2){
                outType='DP';
                endOutFinished();
                return;
            }

            if (selectedBatterPositions.length == 1){
                alert("There was error of the fielder. Please, select a new OUT type.");
                userShouldSelectType = true;
                return;
            }
        }

        endOutFinished();
    }

    function endOutFinished(){
        userShouldSelectType = false;
        isCoordinatesSet = false;
        self.onOut(outType, selectedFielderPositions, selectedBatterPositions);
        outType = null;
        self.enable(false);
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
            errorFielders = [];
            ignoredBatters = [];
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

                if (!!obj.object.attr('error'))
                    errorFielders.push(obj.position);

                if ((outType == 'SacB') && selectedFielderPositions[0] !=3 ){
                    selectedFielderPositions.push(3);

                    if (!!$('.ui-field-element[fielder][position="3"]').attr('error'))
                        errorFielders.push(3);
                }

                if (outType == 'SacB'){
                    self.onBatterBase();
                }

                if (outType == 'SacF'){
                    self.onBatterBase(3);
                }

                if (    outType == 'F' ||
                        outType == 'SacF' ||
                        outType == 'SacB'){
                    selectedBatterPositions.push(0); // current batter

                    if (!!$('.ui-field-element[batter][position="0"]').attr('advanced'))
                        ignoredBatters.push(0);

                    endOut();
                }
            }

            if (obj.type == 'batter'){
                if (selectedFielderPositions.length == 0){
                    alert('You should select fielders first');
                    return;
                }

                if (outType == 'FO' && !isForceOutAllowed(obj.position)){
                    alert('Runner is not forced');
                    return;
                }

                if (selectionMode == 'fielders') {
                    selectionMode = 'batters';
                    selectedBatterPositions = [];
                }

                if (selectedBatterPositions.indexOf(obj.position) != -1)
                    return;

                selectedBatterPositions.push(obj.position);

                if (!!obj.object.attr('advanced'))
                    ignoredBatters.push(obj.position);

                if (selectedBatterPositions.length == outTypePermission[outType]){
                    endOut();
                }
            }
        }
    };

    initMenu();
}