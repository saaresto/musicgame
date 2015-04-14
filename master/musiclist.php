<?php
require_once("../php/AppInfo.php");
require_once("../php/functions.php");
require_once("../php/VKClass.php");
require_once("../php/VKException.php");

$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);

$vk->setToken($_COOKIE['TOKEN']);

$music = getUserMusic($_COOKIE['USER_ID'], 300, $vk);

$music = $music['response'];
$count = $music[0];
?>

<div class="audiofiles-container">
    <h2>Your audiofiles</h2>
    <input id="search-personal-music" type="text" placeholder="Search"/>

    <?php
    for ($i = 1; $i <= $count; $i++) {
        echo getPlayerItem($music[$i]);
    }
    ?>


</div>
<div class="global-audiofiles-container">
    <h2>Audiofiles</h2>
</div>

<script src="js/player.js"></script>