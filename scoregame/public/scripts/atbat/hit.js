function HitController(){
    var self = this;

    var $field = $('.js-field');
    var isEnabled = false;
    var isEnabledParticular = false;
    var hitType = null;

    function initMenu(){
        $.contextMenu({
            selector: '.js-button-hit',
            trigger: 'left',
            items:{
                'HBP':{
                    name: 'HBP',
                    callback: menuHandle
                },
                '1B':{
                    name: '1B',
                    callback: menuHandle
                },
                '2B':{
                    name: '2B',
                    callback: menuHandle
                },
                '3B':{
                    name: '3B',
                    callback: menuHandle
                },
                'HR':{
                    name: 'HR',
                    callback: menuHandle
                }
            }
        });

        self.enable(false);
    }

    function menuHandle(type){
        hitType = type;
        if (   hitType == 'HBP' ||
                hitType == 'BK' ||
                hitType == 'WP' ||
                hitType == 'PB' ||
                hitType == 'CI') {
            self.onPitchError(hitType);
            self.enable(false);
            hitType = null;
            return;
        }
        $('.js-field').attr('active',1);
    }

    function menuHandleParticular(type){
        if (!isEnabledParticular) {
            alert('This option is disabled');
            return;
        }
        menuHandle(type);
    }

    $field.mousedown(function(e){
        if (isEnabled && hitType) {
            var fieldOffset = $field.offset();
            var coordinatesHit = {x: e.pageX - fieldOffset.left, y: e.pageY - fieldOffset.top};

            self.storage.updatePitch({
                type: 'hit',
                type2: hitType,
                coordinatesHit: coordinatesHit
            });

            self.onDrawHit(coordinatesHit);
            self.onDrawLabel(hitType);
            self.onBatterHit(hitType);
            hitType = null;
            self.enable(false);
        }
    });

    $field.mousemove(function(e){
        if (isEnabled && hitType) {
            var fieldOffset = $field.offset();
            self.onDrawHit({x: e.pageX - fieldOffset.left, y: e.pageY - fieldOffset.top});
        }
    });



    $('.js-button-field-hitbypitch').click(function(){
        menuHandleParticular('HBP');
    });

    $('.js-button-field-balk').click(function(){
        menuHandleParticular('BK');
    });

    $('.js-button-field-out-wildpitch').click(function(){
        menuHandleParticular('WP');
    });

    $('.js-button-field-out-passedball').click(function(){
        menuHandleParticular('PB');
    });

    $('.js-button-field-out-catcherinf').click(function(){
        menuHandleParticular('CI');
    });

    self.onBatterHit = function(type){};
    self.onPitchError = function(type){};
    self.onDrawHit = function(point){};
    self.onDrawLabel = function(type){};

    self.menuHandle = function(type){
        return isEnabled && (menuHandle(type) || true);
    };

    self.enable = function(isEnable){
        var button = $('.js-button-hit');
        button.contextMenu(isEnable);

        if(isEnable)
            button.removeAttr('disabled');
        else {
            button.attr('disabled', 1);

            hitType = null;
        }

        $field.removeAttr('active');
        isEnabled = isEnable;
        isEnabledParticular = isEnable;
    };

    self.enableParticular = function(isEnable){
        isEnabledParticular = isEnable;
    };

    initMenu();

    return self;
}