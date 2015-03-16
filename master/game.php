<?php
setcookie('PROGRESS', '0', time() + 60 * 60);
?>

<div class="game-container">
    <div id="ajax-loading"></div>

    <div class="genre-choice-container">
        <h1>Choose the genre</h1>
        <ul class="genre-list">
        <?php
            for ($i = 0; $i < count($GENRES) + 3; $i++) {
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