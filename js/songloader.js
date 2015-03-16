/**
 * Created by Ilya on 23.02.15.
 */

$(document).ready(function(e){

    $("body").on(
        "click",
        ".loadMusic",
        function(e){
            var userId = $(".userIdBox").val();
            var count = $(".countBox").val().length == 0 ? 5 : $(".countBox").val();

            $(".ajaxWait").text("Loading");

            $.ajax({
                type: 'GET',
                url: 'php/ajax.php?loadmusic',
                data: {'uid':userId, 'count':count},
                success: (function(json){
                    $(".ajaxWait").text("Complete").delay(2500).text("");

                    $("body").append(getSongsList(json, count));
                })
            });

        }
    );

});

function getSongsList(json, count) {
    json = JSON.parse(json);
    var response = json.response;
    var c = count > response[0] ? response[0] : count;
    var list = "<ul>";

    for (i = 1; i <= c; i++) {
        var song = response[i];
        list += "<li>";

        list += "<audio controls preload='none'>";
        list += "<source src='" + song.url + "' type='audio/mpeg'>";
        list += "</audio>";

        list += song.artist + " - " + song.title;

        list += "</li>";
    }

    list += "</ul>";

    return list;
}