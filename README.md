# Twitchlite

A lightweight livestream indexer for twitch.

Default limit is 25 livestreams sorted after the most popular. Limit can go up to 100 and the offset can be used to look through less popular channels.

You can also choose livestreams playing a specific game. There is an option to pull the top 10 most popular games for autocompletion.

You can also view livestreams from the channels you follow by providing a oauth token. After you do, a "Only followed" checkbox will appear in the top, where you then can submit a query to only see the channels you follow. The required scope of the oauth token is "user_read". There is an option in functions.php to have this view as the default view.

If you're in need of an oauth token you can check out https://twitchtokengenerator.com/.

For more info on the options check out the twitch API docs.

## Config

For easy configuration place a config.php file in the root directory. Below you can see the available options. The assigned value is the default and in parentheses you can see the available options.

```
<?php
$oauth_token = "";
$only_followed_default = "false"; (true|false)
$default_limit = "25"; (1-100)
$get_top_games = "false"; (true|false)
```

if you wish to change one of the variables in logic.php you can simply override it by placing a variable with the same name in config.php with your desired value.