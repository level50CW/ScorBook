function AdvanceController(){
    var self = this;

    var advancedBy;
    var isEnabled;

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-ar',
            trigger: 'left',
            items:{
                'AR1':{
                    name: 'Advanced by 1 base',
                    callback: menuHandle
                },
                'AR2':{
                    name: 'Advanced by 2 bases',
                    callback: menuHandle
                },
                'AR3':{
                    name: 'Advanced by 3 bases',
                    callback: menuHandle
                }
            }
        });

        self.enable(false);
    }

    function menuHandle(item){
        advancedBy = {'AR1':1, 'AR2': 2, 'AR3': 3}[item];
        $('.js-field').attr('active',1);
    }

    self.onError = function(val){};

    self.enable = function(isEnable){
        isEnabled = isEnable;
        var button = $('.js-button-ar');

        if (isEnable)
            button.removeAttr('disabled');
        else {
            button.attr('disabled', 1);
        }
    };

    self.menuHandle = function(type){
        return isEnabled && (menuHandle(type) || true);
    };

    self.doClick = function(obj){
        if (isEnabled && advancedBy){
            if (obj.type == 'batter'){
                if (!obj.object.attr('advancedBy'))
                    obj.object.attr('advancedBy',advancedBy);
                else
                    obj.object.removeAttr('advancedBy');
            }

            if (obj.type == 'fielder'){
                alert("Fielder can not be advanced");
                return;
            }
            advancedBy = null;
            $('.js-field').removeAttr('active');
        }
    };


    initMenu();
}