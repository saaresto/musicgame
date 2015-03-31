<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 24.02.15
 * Time: 13:41
 */

require_once("AppInfo.php");

function getUserMusic($userid, $count, $vkobj) {
    return $vkobj->api("audio.get", array(
        'owner_id'  => $userid,
        'count'     => $count,
        'need_user' => '0'
    ));
}

function getGlobalMusic($query, $count, $vkobj) {
    $response = $vkobj->api("audio.search", array(
        'q' =>  $query,
        'count' =>  $count,
        'auto_complete' =>  0,
        'search_own'    =>  0
    ));

    return $response['response'];
}

function getUserInfo($userid, $vkobj) {
    $response = $vkobj->api("users.get", array(
        "user_ids"  =>  $userid,
        "fields"    =>  "photo_200, screen_name",
        "lang"      =>  "en"
    ));

    return $response['response'][0];
}

function getSongDuration($duration){
    return gmdate("i:s", $duration);
}

function getPlayerItem($song) {
    $item = "";

    $item .= "<div class='player-item' id='" . $song['aid'] . "-item'>\n";

    $item .= "<audio id=\"".$song['aid']."-audio\" preload='none' ontimeupdate=\"updateProgressBar(".$song['aid'].")\">\n";
    $item .= "<source src=\"".$song['url']."\" type=\"audio/mpeg\">\n";
    $item .= "</audio>\n";

    $item .= "<div class=\"player-item-button\" id=\"".$song['aid']."-btn\" onclick=\"playAudio(".$song['aid'].")\">\n";
    $item .= "<span class=\"glyphicon glyphicon-play\"></span>\n";
    $item .= "</div>\n";

    $item .= "<div class=\"player-item-title\" id=\"".$song['aid']."-title\">".$song['artist']." - ".$song['title']."</div>\n";
    $item .= "<div class=\"player-item-progress\" id=\"".$song['aid']."-timeline\" onclick=\"rewindAudio(".$song['aid'].")\">\n";
    $item .= "<span class=\"progressbar\" id=\"".$song['aid']."-bar\"></span>\n";
    $item .= "</div>\n";
    $item .= "<span class=\"player-item-duration\" id=\"".$song['aid']."-duration\">".getSongDuration($song['duration'])."</span>\n";
    $item .= "</div>\n";

    return $item;
}
?>




