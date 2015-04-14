/**
 * Created by Ilya on 25.02.15.
 */
$(document).ready(function(e){

    /*
    Switching .active on navigation links.
     */
    /*$("aside").on("click", ".navlink", function(e){

        $(".navlink").removeClass("active");
        $(this).addClass("active");

        var url = $(this).attr("data-target");
        var content = $(".content");
        if (url.indexOf("game") > -1) {
            $.ajax({
                url: "game.php",
                beforeSend: function() {
                    content.html("Loading");
                },
                success: function(data) {
                    content.html(data);
                }
            });
        }
    });*/
    var url = window.location + '';
    var pieces = url.split("?");
    var activePage = pieces[1];
    $("a[href*='?" + activePage + "']").addClass("active");
    if (activePage == 'game' || activePage == 'music') {
        //setVolume();
    }
    /*
    Bug fix.
     */
    /*$(window).scroll(function(){
        $("aside").css("height", $(document).height());
    }).resize(function(){
        $("aside").css("height", $(document).height());
    }).load(function(){
        $("aside").css("height", $(document).height());
    });*/

    /*
    Tops
     */
    $(".content").on("click", ".ranks > li", function(e){
        if (!$(this).hasClass("active")) {
            $(".ranks > li").removeClass("active");
            $(this).addClass("active");

            $(".top-details").css("display", "none");
            $(this).children(".top-details").css("display", "block");
        } else {
            $(".top-details").css("display", "none");
            $(this).removeClass("active");
        }

    });
});

/*
function setVolume() {
    var audio = document.getElementsByTagName("audio");
    var volume = document.getElementsByClassName("volume-bar-container")[0];
    var bar = document.getElementsByClassName("volume-bar")[0];
    var icon = document.getElementsByClassName("volume-icon")[0];

    var e = window.event;
    var offsetLeft = 0;
    var offsetTop = 0;
    var node = volume;
    var p;

    if (node.offsetParent) {
        do {
            offsetLeft += node.offsetLeft;
            offsetTop += node.offsetTop;
        } while (node = node.offsetParent);
    }

    //console.log(e.pageX, e.pageY, volume.offsetLeft, volume.offsetTop);

    if (e.pageX > offsetLeft
        && e.pageX < offsetLeft + volume.offsetWidth) {

        //console.log("width passed");
        if (e.pageY > offsetTop && e.pageY < offsetTop + volume.offsetHeight) {

            //console.log("height passed");
            p = (e.pageX - offsetLeft) / volume.offsetWidth;
            console.log(e.pageX, offsetLeft);
            bar.style.width = (100 * p) + "%";

            for (i = 0; i < audio.length; i++) {
                audio[i].volume = p;
            }
        }
    }

    if (p == undefined) {
        return;
    }

    if (p > 0.5) {
        console.log(p, "volume up");
        icon.innerHTML = "<span class='glyphicon glyphicon-volume-up'></span>";
    } else if (p <= 0.5 && p > 0.1) {
        console.log(p, "volume down");
        icon.innerHTML = "<span class='glyphicon glyphicon-volume-down'></span>";
    } else if (p <= 0.1 && p > -1) {
        console.log(p, "volume off");
        icon.innerHTML = "<span class='glyphicon glyphicon-volume-off'></span>";
    }


}*/
