<?php
require_once("../php/AppInfo.php");
/*
* NO GUESTS ALLOWED.
* USER MUST BE LOGGED IN TO VIEW THIS PAGE.
*/
if (!isset($_COOKIE['TOKEN'])) {
    header("location:".$ROOT_URL);
}

require_once("../php/functions.php");
require_once("../php/VKClass.php");
require_once("../php/VKException.php");

?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="css/jquery.growl.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/master.css" rel="stylesheet">
    <link href="css/music.css" rel="stylesheet">
    <link href="css/game.css" rel="stylesheet">
    <meta charset="UTF-8">
    <script src="../js/jquery-1.11.0.min.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="js/jquery.growl.js"></script>
    <script src="js/master.js"></script>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 25.02.15
 * Time: 9:10
 */
/*
 * Database connection.
 */
$link = mysql_connect($DBHOST, $DBUSER, $DBPASSWORD);
mysql_select_db($DBNAME);


/*
 * Api object.
 */
$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);

$vk->setToken($_COOKIE['TOKEN']);

$user = getUserInfo($_COOKIE['USER_ID'], $vk);

/*
 * Insert user data to database.
 */
$insert = "INSERT INTO user_stats(uid, screen_name, win_count, hit_count, successful_hits_count)".
    " VALUES('".$user['uid'] != null ? $user['uid'] : "undefined"."', '".$user['screen_name'] != null ? $user['screen_name'] : "undefined"."', 0, 0, 0)";
if (!mysql_query($insert, $link)) {
    //die("not inserted ".mysql_error());
}
?>

<aside id="sidebar">
    <img src="<?php echo $user['photo_200']; ?>" alt="Avatar"/>

    <a class="username" href="#"><?php echo $user['screen_name'] != null ? $user['screen_name'] : $_COOKIE['USER_ID']; ?></a>
    <hr>

    <a class="navlink emphasize" href="<?php echo $ROOT_URL."master/"; ?>?game">The Game</a>

    <a class="navlink" href="<?php echo $ROOT_URL."master/"; ?>?ratings">Ratings</a>
    <a class="navlink" href="<?php echo $ROOT_URL."master/"; ?>?music">My music</a>
    <a class="navlink" href="<?php echo $ROOT_URL."master/"; ?>?about">About</a>

    <?php if (isset($_GET['game']) || isset($_GET['music'])) { ?>
    <div class="volume-container">
        <div class="volume-icon"><span class="glyphicon glyphicon-volume-up"></span></div>
        <div class="volume-bar-container" onclick="setVolume()">
            <span class="volume-bar"></span>
        </div>
    </div>
    <?php } ?>

    <a class="navlink logout" href="../logout.php?logout">Logout</a>

</aside>

<div class="content">
    <?php
        if (empty($_GET)) {
    ?>
    <div class="wallpaper" style="background: url('../assets/forest<?php echo rand(1,5);?>.jpg')"></div>
    <h1>Welcome to <span class="eleven">Eleven</span></h1>
    <p class="about">Wanna get some fun? Here you get it!</p>
    <p class="about">In <strong>Eleven</strong> you choose your favorite genre (or the one you want to get familiar with) and guess, what song is playing.
    Goal is to guess 10 in a row. What happens next? Exactly nothing except for +1 in your win count, which everyone sees. Go on, keep guessing.</p>
    <p class="about">Music is taken from the VK charts of currently trending songs. The songs will not always be new, but they will be granted (probably) to be loved by lots of people. Knowing them is always useful.</p>
    <?php } ?>

    <?php
    if (isset($_GET['game'])) {
        require_once("game.php");
    ?>

    <?php } ?>

    <?php
        if (isset($_GET['about'])) {
           require_once("about.php");
        }
    ?>

    <?php
        if (isset($_GET['ratings'])) {
            require_once("ratings.php");
        }
    ?>

    <?php
    if (isset($_GET['music'])) {
        require_once("musiclist.php");
        }
    ?>

</div>


</body>
</html>