<?php
require 'logic.php';

if (file_exists("config.php")) {
    include 'config.php';
}
?>
<html>
    <header>
        <link rel=stylesheet href="style.css" type="text/css">
        <title>twitchLite</title>
    </header>
    <body>
        <div class="nav">
            <form class="input" method="get">
                Limit (1-100): <input type="number" min="1" max="100" value="<?php echo $_GET['limit']; ?>" name="limit">
                Offset (0-): <input type="number" min="0" value="<?php echo $_GET['offset']; ?>" name="offset">
                Game: <input type="text" autocomplete="on" name="game" value="<?php echo $_GET['game']; ?>" list="games">
                <?php if (isset($oauth_token) && !empty($oauth_token)) : ?>
                    <input type="hidden" name="only_followed_hidden" value="0">
                    Only followed: <input type="checkbox" name="only_followed" value="1" 
                        <?php echo isset($_GET['only_followed']) ? "checked" : ""; ?> >
                <?php endif; ?>
                <input type="submit" value="Submit">
            </form>
            <span class="total">Total Stream: <?php echo $content["_total"]; ?></span>
            <form class="input-prev-next" method="get">
                <input type="hidden" name="limit" value="<?php echo $_GET['limit']; ?>">
                <button type="submit" name="offset" 
                    value="<?php echo getPrevPageOffset($_GET['limit'], $_GET['offset']); ?>" 
                        <?php echo $_GET['offset'] === "0" ? "disabled" : ""; ?> >Prev</button>
                <button type="submit" name="offset" 
                    value="<?php echo getNextPageOffset($_GET['limit'], $_GET['offset'], $content["_total"]); ?>" 
                        <?php echo $content["_total"] - $_GET['limit'] === $_GET['offset'] ? "disabled" : ""; ?> >Next</button>
                <input type="hidden" name="game" value="<?php echo $_GET['game'];?>">
            </form>
            <?php if (isset($get_top_games) && $get_top_games === true) : ?>
                <datalist id="games">
                    <?php foreach ($games["top"] as $game) : ?>
                        <option value="<?php echo $game["game"]["name"]; ?>">
                    <?php endforeach; ?>
                </datalist>
            <?php endif; ?>
        </div>
        <div id="content">
            <div class="container">
                <?php foreach ($content["streams"] as $stream) : ?>
                    <div class="stream">
                        <a href="<?php echo $stream["channel"]["url"]; ?>">
                            <img src="<?php echo $stream["preview"]["medium"]; ?>">
                        </a>
                        <br>
                        <span class="user">User: <?php echo $stream["channel"]["display_name"]; ?></span><br>
                        <span class="game">Game: <?php echo $stream["game"]; ?></span><br>
                        <span class="viewers">Viewers: <?php echo $stream["viewers"]; ?></span><br>
                        <hr class="status-split">
                        <span class="status"><?php echo $stream["channel"]["status"]; ?></span><br>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>

