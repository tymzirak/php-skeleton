<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(string $arg1="", string $arg2="")
    {
        $this->recordAdd("some_table", ["x" => 1, "y" => 2, "z" => 3]);

        self::view("home.index", ["arg1" => $arg1, "arg2" => $arg2]);
    }
}
