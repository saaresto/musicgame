<?php
/**
 * Created by PhpStorm.
 * User: Ilya
 * Date: 23.02.15
 * Time: 19:39
 */

$APP_ID = '2345622';
$SECRET = 'Sfdmkgdoqwp,v78admj2';
$ROOT_URL = "http://localhost:63342/juke/";
$CALLBACK_URL = $ROOT_URL."authorize.php";
$vk_config = array(
    'app_id'        => $APP_ID,
    'api_secret'    => $SECRET,
    'callback_url'  => $CALLBACK_URL,
    'api_settings'  => 'audio' // In this example use 'friends'.
    // If you need infinite token use key 'offline'.
);
$ONLY_ENG = '1';

// Database info.
$DBHOST = 'localhost';
$DBUSER = 'root';
$DBPASSWORD = 'vertrigo';
$DBNAME = 'jukemaster';


// array_keys($genres);
// array_search(value, array);
$GENRES = array(
    '1'     =>  'Rock',
    '2'     =>  'Pop',
    '3'     =>  'Rap & Hip-Hop',
    '4'     =>  'Easy Listening',
    '5'     =>  'Dance & House',
    '6'     =>  'Instrumental',
    '7'     =>  'Metal',
    '21'    =>  'Alternative',
    '8'     =>  'Dubstep',
    '1001'     =>  'Jazz & Blues',
    '10'    =>  'Drum & Bass',
    '11'    =>  'Trance',
    '13'    =>  'Ethic',
    '14'    =>  'Acoustic & Vocal',
    '15'    =>  'Reggae',
    '16'    =>  'Classical',
    '17'    =>  'Indie Pop',
    '19'    =>  'Speech',
    '22'    =>  'Electropop & Disco',
    '18'    =>  'Other'
);


?>

