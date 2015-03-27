<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 24.02.15
 * Time: 14:28
 */
require("AppInfo.php");
require("VKClass.php");
require("VKException.php");
require_once("functions.php");
$link = mysql_connect($DBHOST, $DBUSER, $DBPASSWORD);
mysql_select_db($DBNAME);
$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);
$vk->setToken($_COOKIE['TOKEN']);

$count = 300;

if (isset($_GET['game'])) {
    $music = $vk->api("audio.getPopular", array(
        'genre_id'  =>  $_GET['genre'],
        'only_eng'  =>  $ONLY_ENG,
        'count'     =>  $count
    ));
    echo json_encode($music);
}
if (isset($_GET['db'])) {
    $column = $_GET['column'];
    $action = $_GET['action'];
    $user = $_COOKIE['USER_ID'];

    $query = "";
    switch ($action) {
        case 'inc':
            $query = "UPDATE user_stats SET ".$column."=".$column."+1 WHERE uid=".$user."";
            break;
        case 'dec':
            $query = "UPDATE user_stats SET ".$column."=".$column."-1 WHERE uid=".$user."";
            break;
    }
    mysql_query($query);
}
?>