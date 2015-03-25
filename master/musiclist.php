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
// TODO make a global search, вынести создание player-item'а в отдельную функцию с массивом $music в параметре
?>

<div class="audiofiles-container">
    <h2>Your audiofiles</h2>
    <input id="search-personal-music" type="text" placeholder="Search"/>

    <?php for ($i = 1; $i <= $count; $i++) {?>

    <div class="player-item" id="<?php echo $music[$i]['aid']; ?>-item">
        <audio id="<?php echo $music[$i]['aid']; ?>-audio" preload='none' ontimeupdate="updateProgressBar(<?php echo $music[$i]['aid']; ?>)">
            <source src="<?php echo $music[$i]['url']; ?>" type="audio/mpeg">
        </audio>
        <div class="player-item-button" id="<?php echo $music[$i]['aid']; ?>-btn" onclick="playAudio(<?php echo $music[$i]['aid']; ?>)"><span class="glyphicon glyphicon-play"></div></button>
        <div class="player-item-title" id="<?php echo $music[$i]['aid']; ?>-title"><?php echo $music[$i]['artist']; ?> - <?php echo $music[$i]['title']; ?></div>
        <div class="player-item-progress" id="<?php echo $music[$i]['aid']; ?>-timeline" onclick="rewindAudio(<?php echo $music[$i]['aid']; ?>)">
            <span class="progressbar" id="<?php echo $music[$i]['aid']; ?>-bar"></span>
        </div>
        <span class="player-item-duration" id="<?php echo $music[$i]['aid']; ?>-duration"><?php echo getSongDuration($music[$i]['duration']); ?></span>
    </div>
    <?php } ?>

</div>


<script src="js/player.js"></script>

<!--<div class="player-item" id="321-item">
    <audio id="321-audio">
        <source src="http://cs1-50v4.vk-cdn.net/p12/4bd3c2bf0d6ab5.mp3?extra=BO9mpqwSyBrb8adj0EbGukGHTZ4gPNbYelWuoBadWbD7EDptv1XJcPwJdJUuOmyxutNYa6bN7GLPlQ4A9GFmIBB5QPJ4OA,220" type="audio/mpeg">
    </audio>
    <div class="player-item-button" id="321-btn" onclick="playAudio(321)"><span class="glyphicon glyphicon-play"></div></button>
    <div class="player-item-title" id="321-title">Lamar - Backseat</div>
    <span class="player-item-duration" id="321-duration">3:40</span>
</div>-->