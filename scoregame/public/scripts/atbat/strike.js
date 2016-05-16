function StrikeController(){
    var self = this;

    var isEnabled;

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-k',
            trigger: 'left',
            items:{
                'KC':{
                    name: 'Strikeout Looking',
                    callback: menuHandle
                },
                'KS':{
                    name: 'Strikeout Swinging',
                    callback: menuHandle
                }
            }
        });

        self.enable(false);
    }

    function menuHandle(item){
        self.enable(false);

        self.storage.updatePitch({type:'out', type2: item});

        self.onStrikeOut(item);
    }

    self.onStrikeOut = function(type){};

    self.menuHandle = function(type){
        return isEnabled && (menuHandle(type) || true);
    };

    self.enable = function(isEnable){
        var button = $('.js-button-k');
        button.contextMenu(isEnable);

        if (isEnable)
            button.removeAttr('disabled');
        else
            button.attr('disabled',1);

        isEnabled = isEnable;
    };

    initMenu();
}