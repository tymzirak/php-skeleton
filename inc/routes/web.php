<?php

use App\Core\Route;
use App\Core\Controller;

Route::setRoute("/", "HomeController@index");

Route::setRoute("/home/{}/{}", "HomeController@index");

Route::setRoute("/some/{}/path/{}", function(string $arg1, string $arg2) {
    echo $arg1 . " " . $arg2;
});

Route::setRoute("/some/{}/path/{}/here", function(string $arg1, string $arg2) {
    Controller::view("home.index", ["arg1" => $arg1, "arg2" => $arg2]);
});

Route::setRoute("/some/cool/path", function() : void {
    echo "hello there";
});
