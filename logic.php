<?php

// Base Variables

$base_url = "https://api.twitch.tv/helix";
$stream_url = "/streams";
$followed_url = "/streams/followed";
$game_url = "/games/top";
$client_id = "tfdaga4350ved4acxim5958z1qcr8y";
$top_games_limit = "10";
$total = "900";

// Config Options

if (file_exists("config.php")) {
    include 'config.php';
}

// Functions

function getRequest(
    $base_url,
    $url_extend,
    $client_id,
    $params = [],
    $oauth = ""
) {
    $request_url = createUrl($base_url, $url_extend, $params);
    $json = curlGet($request_url, $client_id, $oauth);
    return toArray($json);
}

function createUrl($base_url, $url_extend, $params = [])
{
    $param_string = paramToString($params);
    return $base_url . $url_extend . "?" . $param_string;
}

function paramToString($params)
{
    $filtered_params = filterParams($params);
    $string = "";
    foreach ($filtered_params as $param => $value) {
        $string .= "&" . $param . "=" . $value;
    }
    return $string;
}

function filterParams($params)
{
    $new_params = [];
    foreach ($params as $param => $value) {
        switch ($param) {
            case "limit":
                if (is_numeric($value) && ($value > 0) && ($value < 101)) {
                    $new_params["first"] = $value;
                }
                continue 2;
            case "game":
                if (is_numeric($value)) {
                    $new_params["game_id"] = $value;
                }
                continue 2;
            case "user_id":
                $new_params["user_id"] = $value;
                continue 2;
            default:
                continue 2;
        }
    }
    return $new_params;
}

function curlGet($request_url, $client_id, $oauth = "")
{
    $header_array[] = 'Client-ID: ' . $client_id;
    if ($oauth) {
        $header_array[] = 'Authorization: Bearer ' . $oauth;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function toArray($json)
{
    return json_decode($json, true);
}

// Logic

if (!isset($_GET["only_followed"])
    && !isset($_GET["ofh"])
    && isset($only_followed_default)
    && $only_followed_default === true
) {
    $_GET["only_followed"] = "1";
} elseif (!isset($_GET["only_followed"])) {
    $_GET["only_followed"] = "0";
}

if (!isset($_GET['limit']) && isset($default_limit)) {
    $_GET['limit'] = $default_limit;
}

if ($_GET["only_followed"] === "1") {
    $_GET["user_id"] = $user_id;
    $content = getRequest(
        $base_url,
        $followed_url,
        $client_id,
        $_GET,
        $oauth_token
    );
} else {
    $content = getRequest($base_url, $stream_url, $client_id, $_GET, $oauth_token);
}

if (isset($get_top_games) && $get_top_games === true) {
    $games = getRequest($base_url, $game_url, $client_id, ["limit" => $top_games_limit], $oauth_token);
}

if (!isset($_GET['limit']) or $_GET['limit'] === "") {
    $_GET['limit'] = "25";
}

if (!isset($_GET['offset']) or $_GET['offset'] === "") {
    $_GET['offset'] = "0";
}

if (!isset($_GET['game'])) {
    $_GET['game'] = "";
}
