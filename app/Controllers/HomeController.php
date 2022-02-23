<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\HomeService;

class HomeController extends Controller {
    public function index(string $arg1="", string $arg2="") : void {
        $this->recordAdd("some_table", ["x" => 1, "y" => 2, "z" => 3]);
        $homeService = new HomeService();
        $greeting = $homeService->getRandomGreeting();
        self::view("home.index", ["greeting" => $greeting, "arg1" => $arg1, "arg2" => $arg2]);
    }
}
