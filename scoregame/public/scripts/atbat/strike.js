function StrikeController(){
    var self = this;

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-k',
            trigger: 'left',
            items:{
                'looking':{
                    name: 'Strikeout Looking',
                    callback: menuHandle
                },
                'swinging':{
                    name: 'Strikeout Swinging',
                    callback: menuHandle
                }
            }
        });

        self.enable(false);
    }

    function menuHandle(item){
        self.enable(false);

        self.storage.updatePitch({type2: item});

        self.onStrikeOut();
    }

    self.onStrikeOut = function(){};

    self.enable = function(isEnable){
        var button = $('.js-button-k');
        button.contextMenu(isEnable);

        if (isEnable)
            button.removeAttr('disabled');
        else
            button.attr('disabled',1);
    };

    initMenu();
}