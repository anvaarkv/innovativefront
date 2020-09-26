<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:");


/**
 * This script mirrors metaweather API.
 * It offers two commands:
 *
 * command: search
 * uri: weather.php?command=search&keyword={your_keyword}
 *
 * command: location
 * uri: weather.php?command=location&woeid={target_woeid}
 */

/**
 * Declarations
 */
$validCommands = [
    'search',
    'location'
];

$command = isset($_GET['command']) ? $_GET['command'] : null;
$baseUrl = 'https://www.metaweather.com/api/location/';


/**
 * Functions
 */
function quitWithResponse($output, $code = 200) {
    http_response_code($code);

    if(($_GET['command'] == 'search') ){
        echo $output;
        exit;
    }else if (isset($_GET['request']) == 'single'){
        echo $output;
        exit;
    }
    $result = array();
    foreach ($output  as $k => $v){
      $array =   json_decode($v , true);
         foreach ($array as $i => $j){
            if(isset($j['title'])){
                $result[$k][$i] = $j['title'];
            }
            if(isset($j[$k])){
                $result[$k][$i]  = $j[$k];
            }
            $result[$k]['city']  = $array['title'];
            $result[$k]['woeid']  = $array['woeid'];
        }
        
    }

    echo json_encode($result);
    exit;
}

function quitWithJsonResponse($output, $code = 200) {
    return quitWithResponse(
        json_encode($output),
        $code
    );
}

function mirrorToEndpoint($uri) {

    global $baseUrl;
    if(is_array($uri)){
        foreach ($uri as  $ky => $vl){
            $response[] = @file_get_contents($baseUrl . $vl);
        }
    }else{
        $response = @file_get_contents($baseUrl . $uri);
    }
    if ( $response ) {
        return quitWithResponse($response);
    }

    quitWithJsonResponse(['error' => 'Not found'], 404);
}

function requireParameters($params) {
    foreach ($params as $param) {
        if (!isset($_GET[$param])) {
            quitWithJsonResponse(['error' => $param . ' is missing']);
        }
    }
}

/**
 * Commands
 */
function search() {
    requireParameters(['keyword']);
    return mirrorToEndpoint('search/?query=' . $_GET['keyword']);
}

function location() {
    requireParameters(['woeid']);
    return mirrorToEndpoint($_GET['woeid']);
}

/**
 * Execution
 */
if (is_null($command) or !in_array($command, $validCommands)) {
    quitWithJsonResponse(['error' => 'Invalid command'], 422);
}

$command();