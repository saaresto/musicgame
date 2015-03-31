var GENRE = -1;
var FOURTYTWO;
var STREAK = 0;
var cheers = ["Awesome!", "Glorious!", "Unbelievable!", "Legendary!", "Fabulous!", "Spectacular!", "Impossible!"];
var mocks = ["Shameful", "Bad enough", "Miserable", "Mediocre", "W for the Worst"];

$(function(e){

// TODO check 404 on right answer

    // TODO выбирать включение русских треков в ротацию
    /*
        Function hides the current slide, if it exists.
        Shows loading animation.
        Sends ajax-request and invokes getGameSlide() function with received data.
     */
    function getWithAjax() {
        if ($(".slides-container").css("display") == "none") {
            $("#ajax-loading").delay(100).fadeIn();
        } else {
            $(".slides-container").fadeOut();
            $("#ajax-loading").delay(500).fadeIn();
        }
        $.ajax({
            url: '../php/ajax.php?game',
            type: 'GET',
            data: {'genre': GENRE},
            success: function(data) {
                if (data.indexOf('null') > -1) {
                    console.log("RETRYING AJAX QUERY: data is null");
                    $.ajax(this);
                } else {
                    $("#ajax-loading").fadeOut();
                    $(".slides-container").html(getGameSlide(data)).delay(500).fadeIn();
                }
            },
            error: function() {
                console.log("RETRYING AJAX QUERY: error");
                $.ajax(this);
            }
        });
    }

    /*
        Sends an ajax request and updates values in database.
     */
    function updateDatabaseRecord(column, action) {
        $.ajax({
            url: '../php/ajax.php?db',
            type: 'GET',
            data: {column: column, action: action},
            success: function(data) {
                //console.log("db updated");
            }
        });
    }


    /*
        Function pauses currently playing audio.
        Pops up notification.
        Changes progress bar.
        Sets new cookies.
        Invokes getWithAjax().
     */
    function processRightAnswer() {
        updateDatabaseRecord('hit_count', 'inc');
        updateDatabaseRecord('successful_hits_count', 'inc');


        var audio = document.getElementById("quest-audio");
        audio.pause();

        $("#jumbo-notificator").css({backgroundColor:"rgba(0, 255, 0, 0.2)"})
            .html("<p>RIGHT</p>").fadeIn().delay(2000).fadeOut();
        /*if ($ != null && $ != undefined) {
            $.growl.notice({
                title: cheers[getRandomInt(0, cheers.length - 1)],
                message: 'Right'
            });
        }*/


        var progress = parseInt($.cookie('PROGRESS')) + 10;
        $("#percentage").html(progress + "%");
        $("#game-progress-bar").css({
            backgroundColor: '#18DE2B'
        }).animate({width:progress + "%"},1000, 'swing').css({backgroundColor:'#5bc0de'});

        if (progress != 100) {
            $.cookie('PROGRESS', progress);
            STREAK++;
            setTimeout(function(){getWithAjax()}, 2500);
        } else if (progress == 100) {
            updateDatabaseRecord('win_count', 'inc');
            alert("C0ИGЯTUL4T10ИS! ETO WIN!\nГде-то в базе данных заинкрементился счётчик побед. Это того стоило.");
            $.cookie('PROGRESS', 0);
            STREAK++;
            setTimeout(function(){getWithAjax()}, 2500);
        }
    }

    /*
     Function pauses currently playing audio.
     Pops up notification.
     Changes progress bar.
     Sets new cookies.
     Invokes getWithAjax().
     */
    function processWrongAnswer() {
        updateDatabaseRecord('hit_count', 'inc');


        var audio = document.getElementById("quest-audio");
        audio.pause();

        $("#jumbo-notificator").css({backgroundColor:"rgba(255, 0, 0, 0.2)"})
            .html("<p>WRONG</p>").fadeIn().delay(2000).fadeOut();
        /*if ($ != null && $ != undefined)
            $.growl.error({
                title: mocks[getRandomInt(0, cheers.length - 1)],
                message: 'Wrong'
            });*/

        $("#percentage").html("0%");
        $("#game-progress-bar").css({
            backgroundColor: 'red'
        }).animate({width:"0%"},1000, 'swing').css({backgroundColor:'#5bc0de'});

        $.cookie('PROGRESS', '0');
        STREAK = 0;
        setTimeout(function(){getWithAjax()}, 2500);
    }


    /*
        Handles the click, while choosing genre.
        Fades out whole container.
        Invokes getWithAjax().
     */
    $(".genre-list").on("click", ".genre-item", function(){
        $(".genre-choice-container").fadeOut(50);
        console.log("genre is set")
        getWithAjax();
    });


    /*
        Handles options clicks.
     */
    $(".content").on("click", ".game-options > li", function(){
        /*
        If one item is clicked, there should not be any more handlers invoked.s
         */
        $(".game-options > li").each(function(){
            $(this).css("pointer-events", "none");
        });
        //console.log("option clicked");


        var id = $(this).attr("data-songid");

        if (id == FOURTYTWO) {
            $(this).css({
                "color": "rgba(0, 153, 0, 1)",
                "border-bottom-color": "rgb(0, 153, 0)"
            });
            processRightAnswer();
        } else {
            $(this).css({
                "color": "rgba(153, 0, 0, 1)",
                "border-bottom-color": "rgb(153, 0, 0)"
            });
            $(".game-options > li[data-songid=" + FOURTYTWO + "]").css({
                "color": "rgba(0, 153, 0, 1)",
                "border-bottom-color": "rgb(0, 153, 0)"
        });
            processWrongAnswer();
        }
    });
});

function setGenre(gid) {
    GENRE = gid;
}
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/*
    Parses JSON, gets 5 songs from it, choses the right one.

    @return String whole div.game-slide with generated content.
 */
function getGameSlide(json) {
    json = JSON.parse(json);
    if (null == json) {
        console.log("Could not get game slide: response is null");
        return "<pre>Ajax error: could not get data</pre>";
    }
    var music = json.response;
    //console.log("music length:", music.length);

    var maximumOffset = Math.ceil(music.length / 5) - 1;
    //console.log("maxOffset:", maximumOffset);

    var indexes = [];
    for (i = 0; i < 5; i++) {
        indexes[i] = indexes[i - 1] == undefined ? getRandomInt(0, maximumOffset) : indexes[i - 1] + getRandomInt(1, maximumOffset);
    }
    //console.log(indexes);

    shuffle(indexes);
    FOURTYTWO = indexes[getRandomInt(0, indexes.length - 1)];
    //console.log(FOURTYTWO);

    /*var request = new XMLHttpRequest();
    request.open('GET', music[FOURTYTWO]['url'], false);
    request.send(null);
    if (request.status === 200) {
        alert("yep");
    }*/

    var slide = "";

    slide += "<div class='game-slide'>" +
        "<div id='game-progress'>" +
            "<span id='percentage'>" + readCookie('PROGRESS') + "%</span>" +
            "<span id='game-progress-bar' style='width: " + readCookie('PROGRESS') + "%'></span>" +
        "</div>";

    slide += "<div class='jumbo'  style='background-image: url(../assets/forest" + randomNumber(1, 4) + ".jpg)'>" + "<div id='jumbo-notificator'></div> " +
            "<div class='play-quest-button' id='play-quest-button' onclick='playQuest()'>" +
                "<span class='glyphicon glyphicon-play'></span>" +
            "</div>" +
        "</div>";

    slide += "<audio id='quest-audio' preload='none'>" +
            "<source src='" + music[FOURTYTWO]['url'] + "' type='audio/mpeg'>" +
            "</audio>";

    slide += "<ul class='game-options'>";
    for (i = 0; i < indexes.length; i++) {
        slide += "<li data-songid='" + indexes[i] + "'>";

        slide += music[indexes[i]]['artist'] + " - " + music[indexes[i]]['title'];

        slide += "</li>";
    }
    slide += "</ul>";

    slide += "</div>";


    return slide;
}

/*
    Returns the value stored in cookies with certain key.

    @param name cookie key
     @return String cookie value
 */
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

/*
    Handles the click on big play/pause button.
 */
function playQuest() {
    var audio = document.getElementById("quest-audio");
    var button = document.getElementById("play-quest-button");

    if (audio.paused) {
        button.innerHTML = "<span class='glyphicon glyphicon-pause'></span>";
        audio.play();
    } else {
        button.innerHTML = "<span class='glyphicon glyphicon-play'></span>";
        audio.pause();
    }
}

function randomNumber(min, max) {
    return Math.round(Math.random() * (max - min + 1) + min);
}

//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com/array/shuffle [v1.0]
function shuffle(o){ //v1.0
    for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
};