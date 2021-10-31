# Twitchlite

A lightweight livestream indexer for twitch.

It's made with basic PHP, HTML and CSS.

This project is using the Twitch helix api.

Default limit is 25 livestreams sorted after the most popular. Limit can go up to 100 and the offset can be used to look through less popular channels.

You can also choose livestreams playing a specific game. There is an option to pull the most popular games for autocompletion. This is enabled by default, but can be disabled in the config.php. The default amount of games is pulled is 100, but can customized in config.php.

You can also view livestreams from the channels you follow by providing a oauth token. After you do, a "Only followed" checkbox will appear in the top, where you then can submit a query to only see the channels you follow. There is an option you can add to config.php to have this view as the default view.

## Installation

You can either clone the repo and set it up just as you would any other PHP site or you can have a look at the php-fpm based docker container https://hub.docker.com/r/mwalbeck/twitchlite

## Setup

The following setup is only needed if you would like to use the only followed functionality. For it to work you need to an OAuth token and your numerical user id.

### OAuth token

To get an oauth token please navigate to the following link. 

[https://id.twitch.tv/oauth2/authorize?client_id=tfdaga4350ved4acxim5958z1qcr8y&redirect_uri=http://localhost:8081&response_type=token&scope=user:read:follows](https://id.twitch.tv/oauth2/authorize?client_id=tfdaga4350ved4acxim5958z1qcr8y&redirect_uri=http://localhost:8081&response_type=token&scope=user:read:follows)

When you click on it, you will be asked to login to your twitch account if you aren't already logged in. Then you will be redirected to `http://localhost:8081`. The redirect URL should look something like the example below:

`http://localhost:8081/#access_token=ukwr5ypmc3hzkrh7acwsh5x48bfuzy&scope=user%3Aread%3Afollows&token_type=bearer`

You can then take the access_token from that URL. In this example it would be `ukwr5ypmc3hzkrh7acwsh5x48bfuzy`. Place that token in the config file as the oauth_token.

### User ID

After you have got your OAuth token, you can retrieve your user id. To do so simply run the following cURL request, putting in the OAuth token you just got.

```
curl -X GET 'https://api.twitch.tv/helix/users' \
-H 'Authorization: Bearer PUT_OAUTH_TOKEN_HERE' \
-H 'Client-Id: tfdaga4350ved4acxim5958z1qcr8y'
```

Then in begining of the JSON response you should be able to find your id, just grab that and place it into your config.php as the user_id.

## Config

For easy configuration place a config.php file in the root directory. Below you can see the available options. The assigned value is the default and in parentheses you can see the available options.

```
<?php
$oauth_token = "";
$user_id = "";
$only_followed_default = false; (true|false)
$default_limit = "25"; (1-100)
$get_top_games = true; (true|false)
$top_games_limit = "100"; (1-100)
```

if you wish to change one of the variables in logic.php you can simply override it by placing a variable with the same name in config.php with your desired value.

## Demo

If you would like to try out Twitchlite you can visit the demo site at [https://twitchlite.mwalbeck.org](https://twitchlite.mwalbeck.org)
