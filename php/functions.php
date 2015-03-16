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
?>




