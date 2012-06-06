$(document).ready(function() {
    $('.photo').fadeTo('fast', 0.5);
    
    $('.photo').hover(function(e) {
        $(this).fadeTo('slow', 1.0);
    }, function(e) {
        $(this).fadeTo('slow', 0.5);
    });
});