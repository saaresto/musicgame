<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 23.02.15
 * Time: 20:29
 */

require_once("php/AppInfo.php");


if (isset($_GET['logout'])) {
    setcookie('TOKEN', "", time() - 1);
    setcookie('USER_ID', "", time() - 1);
}

header("location:$ROOT_URL");
?>