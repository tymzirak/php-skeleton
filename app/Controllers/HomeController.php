<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(string $arg1="", string $arg2=""): void
    {
        $this->recordAdd("some_table", ["x" => 1, "y" => 2, "z" => 3]);

        self::view("home.index", ["arg1" => $arg1, "arg2" => $arg2]);
    }
}
