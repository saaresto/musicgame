<!DOCTYPE html>
<html>
<head>
    <title>Eleven - the music quest.</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/index.js"></script>
</head>
<body style="background: url('assets/bgtree2.jpg'); background-size: cover;">

<?php
require("php/VKClass.php");
require("php/VKException.php");
require("php/AppInfo.php");
require("php/functions.php");


/*
 * Database creation
 */

$link = mysql_connect($DBHOST, $DBUSER, $DBPASSWORD);

if (!mysql_select_db($DBNAME)) {
    mysql_query("CREATE DATABASE ".$DBNAME);
}
if (mysql_select_db($DBNAME)) {
    $table = "CREATE TABLE IF NOT EXISTS user_stats(".
        "uid varchar(15) PRIMARY KEY NOT NULL UNIQUE, ".
        "screen_name varchar (20) DEFAULT 'username' NOT NULL, ".
        "win_count int DEFAULT 0 NOT NULL, ".
        "hit_count int DEFAULT 0 NOT NULL, ".
        "successful_hits_count int DEFAULT 0 NOT NULL);";
    $result = mysql_query($table, $link);
    if (!$result) {
        die("no table ".mysql_error());
    }
}

/*
 * Object to communicate with API.
 */
$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);

if (!isset($_COOKIE['TOKEN'])){
    $authorize_url = $vk->getAuthorizeUrl($vk_config['api_settings'], $vk_config['callback_url']);
?>

<!-- PAGE CONTENTS -->

<div class="welcome" id="welcome">
    <img src="assets/logo.png" width="400" style="margin-bottom: -40px; margin-top: -15px">
    <h1>Welcome to Eleven</h1>
    <p>You have to be logged in via VK account to get in.
        <br/>Enjoy playing!</p>
    <a href="<?php echo $authorize_url; ?>">Sign in with VK</a>
</div>


<?php
} else {
    header("location:master/");
}
?>



</body>
</html>