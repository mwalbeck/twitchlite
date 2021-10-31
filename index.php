<?php
require 'logic.php';
?>
<html>
    <header>
        <link rel=stylesheet href="style.css" type="text/css">
        <title>twitchLite</title>
    </header>
    <body>
        <nav>
            <form class="input" method="get">
                <label for="limit">Limit (1-100):</label>
                <input id="limit" type="number" min="1" max="100" value="<?php echo $_GET['limit']; ?>" name="limit">
                <label for="game">Game:</label>
                <input id="game" type="text" autocomplete="off" name="game" value="<?php echo $_GET['game']; ?>" list="games">
                <?php if (isset($oauth_token) && !empty($oauth_token)) : ?>
                    <label for="only_followed">Only followed:</label>
                    <input id="only_followed" type="checkbox" name="only_followed" value="1" 
                        <?php echo $_GET['only_followed'] === "1" ? "checked" : ""; ?> >
                    <input type="hidden" name="ofh" value="0">
                <?php endif; ?>
                <input type="submit" value="Submit">
            </form>
            <form class="input-prev-next" method="get">
                <input type="hidden" name="limit" value="<?php echo $_GET['limit']; ?>">
                <button type="submit" name="" value="">To begining</button>
                <button type="submit" name="after" value="<?php echo array_key_exists("pagination", $content) ? $content["pagination"]["cursor"] : ""; ?>">Next</button>
                <input type="hidden" name="game" value="<?php echo $_GET['game']; ?>">
                <input type="hidden" name="only_followed" value="<?php echo $_GET['only_followed'] ? "1" : "0"; ?>">
            </form>
            <?php if (isset($get_top_games) && $get_top_games === true) : ?>
                <datalist id="games">
                    <?php foreach ($games["data"] as $game) : ?>
                        <option value="<?php echo $game["id"]; ?>"><?php echo $game["name"]; ?></option>
                    <?php endforeach; ?>
                </datalist>
            <?php endif; ?>
        </nav>
        <div id="content">
            <div class="container">
                <?php foreach ($content["data"] as $stream) : ?>
                    <?php if (isset($_GET['only_followed']) && !empty($_GET['game']) && $_GET['game'] !== $stream["game_id"]) {
    continue;
} ?>
                    <div class="stream">
                        <a href="https://twitch.tv/<?php echo $stream["user_login"]; ?>">
                            <img src="<?php echo str_replace(["{width}", "{height}"], ["320", "180"], $stream["thumbnail_url"]); ?>">
                        </a>
                        <br>
                        <span class="user"><strong>User:</strong> <?php echo $stream["user_name"]; ?></span><br>
                        <span class="game"><strong>Game:</strong> <?php echo $stream["game_name"]; ?></span><br>
                        <span class="viewers"><strong>Viewers:</strong> <?php echo $stream["viewer_count"]; ?></span><br>
                        <a href="<?php echo "https://twitch.tv/popout/" . $stream["user_login"] . "/chat" ?>">
                            <span class="chat">Link to chat</span>
                        </a>
                        <hr class="status-split">
                        <span class="status"><?php echo $stream["title"]; ?></span><br>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>
