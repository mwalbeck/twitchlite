<?php
include 'functions.php';
$content = get_request($base_url, $client_id, $stream_url, $_GET);
$games = get_request($base_url, $client_id, $game_url);
?>
<html>
    <header>
        <link rel=stylesheet href="style.css" type="text/css">
    </header>
    <body>
        <div class="nav">
            <form class="input" method="get">
                Limit (1-100): <input type="number" min="1" max="100" value="<?php echo $_GET['limit'] ? $_GET['limit'] : "25"; ?>" name="limit">
                Offset (0-): <input type="number" min="0" value="<?php echo $_GET['offset'] ? $_GET['offset'] : "0"; ?>" name="offset">
                Game: <input type="text" autocomplete="on" name="game" value="<?php echo $_GET['game']; ?>" list="games">
                <input type="submit" value="Submit">
            </form>
            <span class="total">Total Stream: <?php echo $content["_total"]; ?></span>
            <datalist id="games">
                <?php foreach($games["top"] as $game) : ?>
                    <option value="<?php echo $game["game"]["name"]; ?>">
                <?php endforeach; ?>
            </datalist>
        </div>
        <div id="content">
            <div class="container">
                <?php foreach($content["streams"] as $stream) : ?>
                    <div class="stream">
                        <a href="<?php echo $stream["channel"]["url"]; ?>"><img src="<?php echo $stream["preview"]["medium"]; ?>"></a><br>
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
