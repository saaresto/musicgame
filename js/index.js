/**
 * Created by Ilya on 24.02.15.
 */


$(document).ready(function(e){

    var bH = $(".welcome").height();
    var wH = $(window).height();

    var offset = (wH - bH) / 2;

    if (offset > 205) {
        offset = 205;
    }

    $(".welcome").css("top", offset);

    $(".welcome").fadeIn(500);
});