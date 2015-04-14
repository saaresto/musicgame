<?php
/*
 * Database connection.
 */
$link = mysql_connect($DBHOST, $DBUSER, $DBPASSWORD);
mysql_select_db($DBNAME);

$createQuery = "CREATE TABLE IF NOT EXISTS comments(".
    "cid INTEGER PRIMARY KEY NOT NULL UNIQUE AUTO_INCREMENT, ".
    "username VARCHAR(20), ".
    "comment_text VARCHAR(500), ".
    "user_photo VARCHAR(100)".
    ");";
mysql_query($createQuery, $link) or die (mysql_error());

if (isset($_POST['comment']) && isset($_POST['username']) && isset($_POST['user_photo'])) {
    $query = "INSERT INTO comments(username, comment_text, user_photo) VALUES('".mysql_real_escape_string($_POST['username'])."','".mysql_real_escape_string($_POST['comment'])."','".mysql_real_escape_string($_POST['user_photo'])."')";
    mysql_query($query) or die (mysql_error());
}
// TODO input validation
?>

<div class="sendarea" xmlns="http://www.w3.org/1999/html">
    <form action="?discuss" method="post">
        <label>
            Write your comment here<br>
            <textarea class="comment-textarea" name="comment"></textarea>
            <input type="hidden" name="username" value="<?php echo $user['screen_name'] != null ? $user['screen_name'] : $_COOKIE['USER_ID']; ?>">
            <input type="hidden" name="user_photo" value="<?php echo $user['photo_200']; ?>"/>
        </label>
        <input class="send-comment" type="submit" value="Send"/>
    </form>

    <?php
    $query = "SELECT * FROM comments ORDER BY cid DESC;";
    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
    ?>
        <div class="comment">
            <div class="userpic">
                <img src="<?php echo $row['user_photo']; ?>" alt="Avatar"/>
            </div>
            <div class="comment-data">
                <h5><?php echo $row['username']; ?></h5>
                <p><?php echo $row['comment_text']; ?></p>
            </div>
        </div>
    <?php } ?>
</div>