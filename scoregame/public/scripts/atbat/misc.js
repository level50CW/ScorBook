function MiscController(){
    var self = this;

    var stealType;
    var isEnabled;

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-steal',
            trigger: 'left',
            items:{
                'SB':{
                    name: 'Stolen Base',
                    callback: menuHandle
                },
                'CS':{
                    name: 'Caught Stealing',
                    callback: menuHandle
                }
                //'WP':{
                //    name: 'Wild Pitch',
                //    disabled: true
                //}
            }
        });

        self.enable(false);
    }

    function menuHandle(item){
        if (!isStealAllowed()){
            alert('You can not do this action. The action limited by number of saved bases.');
            return;
        }

        stealType = item;
        $('.js-field').attr('active',1);
    }

    function isStealAllowed(){
        var baseState = self.storage.getBaseState();
        var filled = baseState.bases.filter(function(x){return x;}).length;
        return filled>0;
    }

    self.onOut = function(batter){};
    self.onBatterBase = function(batter){};

    self.enable = function(isEnable){
        isEnabled = isEnable;
        var button = $('.js-button-steal');
        button.contextMenu(isEnable);

        if (isEnable)
            button.removeAttr('disabled');
        else {
            button.attr('disabled', 1);
            stealType = null;
        }
    };

    self.menuHandle = function(type){
        return isEnabled && (menuHandle(type) || true);
    };

    self.doClick = function(obj){
        if (isEnabled && stealType){
            if (obj.type == 'fielder'){
                alert('You should select batters');
                return;
            }

            if (obj.type == 'batter'){
                var baseState = self.storage.getBaseState();
                if (obj.position<3 && !!baseState.bases[obj.position+1]){
                    alert('You can not do this action. The base is occupied.');
                    return;
                }

                if (obj.position == 0){
                    alert('You can not do this action. The batter is at bat.');
                    return;
                }


                if (stealType == 'SB'){
                    self.onBatterBase(obj.position);
                }

                if (stealType == 'CS'){
                    self.onOut(obj.position);
                }

                stealType = null;
                $('.js-field').removeAttr('active');
            }
        }
    };

    initMenu();
}