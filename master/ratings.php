<?php
/*
 * Database connection.
 */
$link = mysql_connect($DBHOST, $DBUSER, $DBPASSWORD);
mysql_select_db($DBNAME);

$leaders_query = "SELECT * FROM user_stats WHERE hit_count>0 ORDER BY user_stats.successful_hits_count/user_stats.hit_count*(1+win_count) DESC";
$leaders = mysql_query($leaders_query);
if (!$leaders) {
    die(mysql_error());
}

?>

<div class="wallpaper" style="background: url('../assets/forest<?php echo rand(1,5);?>.jpg')"></div>
<div class="top">
    <h1>Top-10 players</h1>
    <p style="color:rgba(0,0,0,0.6); font-size:17px">Rating is calculated as (SUCCESSFUL_HITS / TOTAL_HITS) * (1 + WIN_COUNT).</p>
    <ol class="ranks">
        <?php
            while ($leader = mysql_fetch_array($leaders)) {
            ?>
                <li><a title="Go to VK page" target="_blank" href="http://vk.com/<?php echo $leader['screen_name'] ?>"><?php echo $leader['screen_name'] ?></a>
                    <span>
                        <?php
                        echo $leader['hit_count'] != 0 ? round($leader['successful_hits_count']/$leader['hit_count']*(1+$leader['win_count']), 3) : 0;
                        ?>
                    </span>

                <ul class="top-details">
                <li>Wins: <span><?php echo $leader['win_count'] ?></span></li>
                <li>Hits: <span><?php echo $leader['hit_count'] ?></span></li>
                <li>Successful hits: <span><?php echo $leader['successful_hits_count'] ?></span></li>
                </ul>

                </li>
            <?php
            }
        ?>
    </ol>
</div>
<?php
$self_query = "SELECT * FROM user_stats WHERE uid=".$_COOKIE['USER_ID'].";";
$self = mysql_query($self_query);
$self = mysql_fetch_array($self);
?>
<div class="motivation">
    <h1>Your stats</h1>
    <div class="self-stats-block">
        <span class="self-stats-name"><strong>Position in global rating:</strong></span>
        <span class="self-stats-value" style="color: #5bc0de">
            <?php
            if ($self['hit_count'] > 0) {
                $query = "SELECT count(*) FROM user_stats WHERE user_stats.successful_hits_count/user_stats.hit_count*(1+win_count) > ";
                $query .= "(SELECT user_stats.successful_hits_count/user_stats.hit_count*(1+win_count) FROM user_stats WHERE uid=".$_COOKIE['USER_ID'].");";
                $rs = mysql_fetch_array(mysql_query($query));
                print_r($rs[0] + 1);
            } else {
                echo("0");
            }
            ?>
        </span>
    </div>
    <div class="self-stats-block">
        <span class="self-stats-name">Total hits:</span>
        <span class="self-stats-value"><?php echo $self['hit_count'] ?></span>
    </div>
    <div class="self-stats-block">
        <span class="self-stats-name">Successful hits:</span>
        <span class="self-stats-value"><?php echo $self['successful_hits_count'] ?></span>
    </div>
    <div class="self-stats-block">
        <span class="self-stats-name">Total wins:</span>
        <span class="self-stats-value"><?php echo $self['win_count'] ?></span>
    </div>
    <div class="self-stats-block">
        <span class="self-stats-name">Hit rate:</span>
        <span class="self-stats-value"><?php
            echo $self['hit_count'] != 0 ? round($self['successful_hits_count']/$self['hit_count'], 3) : 0;
            ?></span>
    </div>



</div>