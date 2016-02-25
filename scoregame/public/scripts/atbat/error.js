function ErrorController(){
    var self = this;

    var playerSelected;
    var isEnabled;

    $('.js-button-err').click(function(){
        if (!$(this).attr('disabled')){
            playerSelected = false;
            $('.js-field').css('background-color','#222');
        }
    });

    self.onError = function(val){};

    self.enable = function(isEnable){
        isEnabled = isEnable;
        var button = $('.js-button-err');

        if (isEnable)
            button.removeAttr('disabled');
        else {
            button.attr('disabled', 1);
        }
    };

    self.doClick = function(obj){
        if (isEnabled && playerSelected === false){
            if (obj.type == 'batter'){
                if (!obj.object.attr('advanced'))
                    obj.object.attr('advanced',1);
                //else
                //    obj.object.removeAttr('advanced');
            }

            if (obj.type == 'fielder'){
                if (!obj.object.attr('error')) {
                    obj.object.attr('error', 1);
                    self.onError(1);
                }
                //else {
                //    obj.object.removeAttr('error');
                //    self.onError(-1);
                //}
            }
            playerSelected = true;
            $('.js-field').css('background-color','#000');
        }
    };
}