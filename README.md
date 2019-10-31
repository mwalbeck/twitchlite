# Twitchlite

A lightweight livestream indexer for twitch.

It's made with basic PHP, HTML and CSS.

This project is using the Twitch v5 api.

Default limit is 25 livestreams sorted after the most popular. Limit can go up to 100 and the offset can be used to look through less popular channels.

You can also choose livestreams playing a specific game. There is an option to pull the most popular games for autocompletion. The default amount of games is pulled is 10, but can customized in config.php to a maximum of 100.

You can also view livestreams from the channels you follow by providing a oauth token. After you do, a "Only followed" checkbox will appear in the top, where you then can submit a query to only see the channels you follow. The required scope of the oauth token is "user_read". There is an option you can add to config.php to have this view as the default view.

If you're in need of an oauth token you can check out https://twitchtokengenerator.com/.

## Config

For easy configuration place a config.php file in the root directory. Below you can see the available options. The assigned value is the default and in parentheses you can see the available options.

```
<?php
$oauth_token = "";
$only_followed_default = false; (true|false)
$default_limit = "25"; (1-100)
$get_top_games = false; (true|false)
$top_games_limit = "10"; (1-100)
```

if you wish to change one of the variables in logic.php you can simply override it by placing a variable with the same name in config.php with your desired value.
