<?php
$base_url = "https://api.twitch.tv/kraken";
$client_id = "";
$stream_url = "/streams";
$game_url = "/games/top";

function get_request($base_url, $client_id, $url_extend, $params = []) {
    $request_url = create_url($base_url, $client_id, $url_extend, $params);
    $json = curl_get($request_url);
    return to_array($json);
}

function curl_get($request_url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $request_url);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function create_url($base_url, $client_id, $url_extend, $params = []) {
    $param_string = param_to_string($params);
    return $base_url . $url_extend . "?client_id=" . $client_id . $param_string;
}

function param_to_string($params) {
    $filtered_params = filter_params($params);
    $string = "";
    foreach ($filtered_params as $param => $value) {
        $string .= "&" . $param . "=" . $value;
    }
    return $string;
}

function to_array($json) {
    return json_decode($json, true);
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