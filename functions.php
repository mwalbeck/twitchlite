<?php
$base_url = "https://api.twitch.tv/kraken";
$stream_url = "/streams";
$followed_url = "/streams/followed";
$game_url = "/games/top";
$client_id = "tfdaga4350ved4acxim5958z1qcr8y";
$oauth_token = "";
$only_followed_default = false;
$get_top_games = true;

function get_request($base_url, $url_extend, $client_id, $params = [], $oauth = "") {
    $request_url = create_url($base_url, $url_extend, $params);
    $json = curl_get($request_url, $client_id, $oauth);
    return to_array($json);
}

function create_url($base_url, $url_extend, $params = []) {
    $param_string = param_to_string($params);
    return $base_url . $url_extend . "?" . $param_string;
}

function param_to_string($params) {
    $filtered_params = filter_params($params);
    $string = "";
    foreach ($filtered_params as $param => $value) {
        $string .= "&" . $param . "=" . $value;
    }
    return $string;
}

function filter_params($params) {
    $new_params = [];
    foreach ($params as $param => $value) {
        switch ($param) {
            case "limit":
                if (is_numeric($value) && ($value > 0) && ($value < 100)) {
                    $new_params[$param] = $value;
                }
                continue;
            case "offset":
                if (is_numeric($value) && $value >= 0) {
                    $new_params[$param] = $value;
                }
                continue;
            case "game":
                $new_params[$param] = urlencode($value);
                continue;
            default:
                continue;
        }
    }
    return $new_params;
}

function curl_get($request_url, $client_id, $oauth = "") {
    $header_array[] = 'Accept: application/vnd.twitchtv.v5+json';
    $header_array[] = 'Client-ID: ' . $client_id;
    if ($oauth) {
        $header_array[] = 'Authorization: OAuth ' . $oauth;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function to_array($json) {
    return json_decode($json, true);
}