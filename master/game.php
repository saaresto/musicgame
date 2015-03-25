<?php
setcookie('PROGRESS', '0', time() + 60 * 60);
?>

<div class="game-container">
    <p style="opacity: 0.5; font-size: 13px">Due to unknown reason VK sometimes returns a broken link to an audiofile. That might become a reason why you can't hear anything. If track is not playing after 15 seconds, probably, it is time to test your luck.</p>
    <div id="ajax-loading"></div>

    <div class="genre-choice-container">
        <h1>Choose the genre</h1>
        <ul class="genre-list">
        <?php
            for ($i = 0; $i < 1002 + 3; $i++) {
                if (isset($GENRES[$i])) {
                    echo "<li class='genre-item' id='genre-$i' onclick='setGenre($i)'>".$GENRES[$i]."</li>";
                }
            }
        ?>
        </ul>
    </div>

    <div class="slides-container">

    </div>


</div>
<script src="js/game.js"></script>