<?php

use App\Core\Route;
use App\Core\Controller;

Route::setRoute("/", "HomeController@index", "GET");

Route::setRoute("/home/{}/{}", "HomeController@index", "GET");

Route::setRoute("/some/{}/path/{}", function(string $arg1, string $arg2) {
    echo $arg1 . " " . $arg2;
}, "GET");

Route::setRoute("/some/{}/path/{}/here", function(string $arg1, string $arg2) {
    Controller::view("home.index", ["arg1" => $arg1, "arg2" => $arg2]);
}, "GET");

Route::setRoute("/some/cool/path", function() {
    echo "hello there";
}, "GET");
