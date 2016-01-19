$(function() {

    // Create overlay and append to body:
    $('<div id="overlay"/>').css({
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100&#37;',
        height: $(window).height() + 'px',
        background: 'white url(images/loader.gif) no-repeat center'
    }).hide().appendTo('#body_div');

});