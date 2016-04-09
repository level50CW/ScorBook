function HitController(){
    var self = this;

    var $field = $('.js-field');
    var isEnabled = false;
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
        if (hitType == 'HBP') {
            self.onHitByPitch();
            self.enable(false);
            hitType = null;
            return;
        }
        $('.js-field').attr('active',1);
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

    self.onBatterHit = function(type){};
    self.onHitByPitch = function(){};
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
    };

    initMenu();

    return self;
}