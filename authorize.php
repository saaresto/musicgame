<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 23.02.15
 * Time: 20:46
 */

require("php/VKClass.php");
require("php/VKException.php");
require("php/AppInfo.php");

if (isset($_REQUEST['code'])) {
    /*
     * Object to communicate with API.
     */
    $vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret']);


    try {
        $access_token = $vk->getAccessToken(
            $_REQUEST['code'], $vk_config['callback_url']);
        //print_r($access_token);

        setcookie('TOKEN', $access_token['access_token'], time() + $access_token['expires_in']);
        setcookie('USER_ID', $access_token['user_id'], time() + $access_token['expires_in']);
    } catch (\VK\VKException $v) {
        print_r($v->getTrace());
    }

}
//echo "<script>setTimeout(function(){window.location.href='master/'}, 0)</script>";
header("location:$ROOT_URL");
?>