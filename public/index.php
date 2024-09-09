<?php
require '../bootstrap.php';

use Src\Controllers\FilmController;
use Src\TableGateways\LogGateway;
use Src\Models\Log;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_arr = explode( '/', $uri );

// all of our endpoints start with /person
// everything else results in a 404 Not Found
if ($uri_arr[1] == 'films') {
    $filmId = null;
    if (isset($uri_arr[2])) {
        $filmId = (int) $uri_arr[2];
    }

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    $log = new Log($requestMethod, $uri);
    $logGW = new LogGateway($dbConnection);
    $logGW->insert($log);


    // pass the request method and user ID to the PersonController and process the HTTP request:
    $controller = new FilmController($dbConnection, $requestMethod, $filmId);
    return $controller->processRequest();
}

// the user id is, of course, optional and must be a number:

header("HTTP/1.1 404 Not Found");
exit();