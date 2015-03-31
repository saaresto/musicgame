
$(function(){
    var input = $("#search-personal-music");
    var request;

    input.on("keyup", function() {
        var value = $(this).val().toLowerCase();

        if (value.length < 1) {
            $(".global-audiofiles-container").css("display", "none");
        }

        var playerItems = $(".player-item");
        playerItems.each(function() {
           var childTitle = $(this).find(".player-item-title");
            var childTitleVal = childTitle.html().toLowerCase();
            if (childTitleVal.indexOf(value) > -1) {
                $(this).css("display", "block");
            } else {
                $(this).css("display", "none");
            }
        });

        if (!(undefined === request)) {
            request.abort();
        }
        if (value.length > 0) {
            request = $.ajax({
                type: 'GET',
                url: '../php/ajax.php?music',
                data: {'count': 10, 'query': value},
                beforeSend: function() {
                    $(".global-audiofiles-container").css("display", "block");
                    $(".global-audiofiles-container").html("<h2>Audiofiles</h2><div id='ajax-loading'></div>");
                    $("#ajax-loading").fadeIn();
                },
                success: function(data) {
                    $("#ajax-loading").fadeOut();
                    $(".global-audiofiles-container").delay(300).append(data);
                }
            });
        }
        // TODO догрузить больше 10 песен
    })
});


function playAudio(id) {
    /*
    Current audio.
     */
    var audio = document.getElementById(id + "-audio");
    var duration_span = document.getElementById(id + "-duration");
    var button = document.getElementById(id + "-btn");

    if (!audio.paused) {
        button.innerHTML = "<span class='glyphicon glyphicon-play'></span>";
        audio.pause();
        console.log(id + " paused");
    } else {
        button.innerHTML = "<span class='glyphicon glyphicon-pause'></span>";
        audio.play();
        console.log(id + (audio.currentTime != 0 ? " unpaused" : " playing"));
    }

    /*
     Stop all players.
     */
    var players = document.getElementsByTagName("audio");
    var buttons = document.getElementsByClassName("player-item-button");
    for (i = 0; i < players.length; i++) {

        if (players[i] !== audio){
            buttons[i].innerHTML = "<span class='glyphicon glyphicon-play'></span>";
            players[i].pause();
            if (!isNaN(players[i].duration))  players[i].currentTime = 0;
        }
    }


}

function updateProgressBar(id) {

    var bar = document.getElementById(id + "-bar");
    var audio = document.getElementById(id + "-audio");

    var percentage = 100 * audio.currentTime / audio.duration;

    bar.style.width = percentage  + "%";

    if (audio.ended) {
        bar.style.width = 0  + "%";
        var button = document.getElementById(id + "-btn");
        button.innerHTML = "<span class='glyphicon glyphicon-play'></span>";
    }
}

function rewindAudio(id) {
    var timeline = document.getElementById(id + "-timeline");
    var bar = document.getElementById(id + "-bar");
    var audio = document.getElementById(id + "-audio");

    if (audio.paused) {
        return;
    }

    var e = window.event;

    var timeOffsetLeft = 0;
    var timeOffsetTop = 0;
    var node = timeline;

    if (node.offsetParent) {
        do {
            timeOffsetLeft += node.offsetLeft;
            timeOffsetTop += node.offsetTop;
        } while (node = node.offsetParent);
    }
    /*console.log(e.pageX, e.pageY, '\n', timeOffsetLeft, ":", timeOffsetTop, timeOffsetLeft + timeline.offsetWidth, ":", timeOffsetTop + timeline.offsetHeight);*/

    if (e.pageX > timeOffsetLeft
        && e.pageX < timeOffsetLeft + timeline.offsetWidth) {

        //console.log("width passed");
        if (e.pageY > timeOffsetTop && e.pageY < timeOffsetTop + timeline.offsetHeight) {

            //console.log("height passed");
            var p = (e.pageX - timeOffsetLeft) / timeline.offsetWidth;
            bar.style.width = (100 * p) + "%";

            audio.currentTime = audio.duration * p;
        }
    }
}

function getTime(duration) {
    var minutes = Math.floor(duration / 60);
    var seconds = Math.floor(duration - minutes * 60);
    return minutes + ":" + seconds;
}