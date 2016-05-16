$(document).ready(function(){
    $('.ui-menu').find('a').click(function(){
        $('form')
            .append(
            $('<input type="hidden" name="redirect">')
                .val($(this).attr('href')))
            .submit();
        return false;
    });
});