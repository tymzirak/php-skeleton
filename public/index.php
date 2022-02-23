<?php

require_once "../paths.php";

require_once ROOT . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

use \App\Core\Route;
use \App\Core\Controller;

require_once INC . "debug" . DIRECTORY_SEPARATOR . "error_show.php";

require_once INC . "routes" . DIRECTORY_SEPARATOR . "web.php";

try { new Route; }
catch (\App\Exceptions\RouteException $e) {
    Controller::view("error.error_page", ["message" => "404 Not Found"]);
}
