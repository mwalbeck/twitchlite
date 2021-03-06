<?php
require 'logic.php';
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
                Offset (0-900): <input type="number" min="0" max="900" value="<?php echo $_GET['offset']; ?>" name="offset">
                Game: <input type="text" autocomplete="on" name="game" value="<?php echo $_GET['game']; ?>" list="games">
                <?php if (isset($oauth_token) && !empty($oauth_token)) : ?>
                    Only followed: <input type="checkbox" name="only_followed" value="1" 
                        <?php echo $_GET['only_followed'] === "1" ? "checked" : ""; ?> >
                    <input type="hidden" name="ofh" value="0">
                <?php endif; ?>
                <input type="submit" value="Submit">
            </form>
            <form class="input-prev-next" method="get">
                <input type="hidden" name="limit" value="<?php echo $_GET['limit']; ?>">
                <button type="submit" name="offset"
                    value="<?php echo getPrevPageOffset($_GET['limit'], $_GET['offset']); ?>"
                        <?php echo $_GET['offset'] === "0" ? "disabled" : ""; ?> >Prev</button>
                <span>Page <?php echo floor($_GET['offset'] / $_GET['limit']) + 1; ?> </span>
                <button type="submit" name="offset"
                    value="<?php echo getNextPageOffset($_GET['limit'], $_GET['offset'], $total); ?>" 
                        <?php echo $total <= $_GET['offset'] ? "disabled" : ""; ?>>Next</button>
                <input type="hidden" name="game" value="<?php echo $_GET['game']; ?>">
                <input type="hidden" name="only_followed" value="<?php echo $_GET['only_followed'] ? "1" : "0"; ?>">
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
                    <?php if (isset($_GET['only_followed']) && isset($_GET['only_followed']) && !empty($_GET['game']) && strtolower($_GET['game']) !== strtolower($stream["game"])) { continue; } ?>
                    <div class="stream">
                        <a href="<?php echo $stream["channel"]["url"]; ?>">
                            <img src="<?php echo $stream["preview"]["medium"]; ?>">
                        </a>
                        <br>
                        <span class="user"><strong>User:</strong> <?php echo $stream["channel"]["display_name"]; ?></span><br>
                        <span class="game"><strong>Game:</strong> <?php echo $stream["game"]; ?></span><br>
                        <span class="viewers"><strong>Viewers:</strong> <?php echo $stream["viewers"]; ?></span><br>
                        <a href="<?php echo "https://twitch.tv/popout/" . $stream["channel"]["name"] . "/chat" ?>">
                            <span class="chat">Link to chat</span>
                        </a>
                        <hr class="status-split">
                        <span class="status"><?php echo $stream["channel"]["status"]; ?></span><br>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>
