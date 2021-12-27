$(function() {
    $(window).resize(function() {
        if($('.wrapper').height() > $(window).height()) {
            $('body').css('height', 'auto');
        } else {
            $('body').css('height', '100%');
        }
    }).trigger('resize');
});
