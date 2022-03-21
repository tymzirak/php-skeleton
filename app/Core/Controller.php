<?php

namespace App\Core;


abstract class Controller extends Database
{
    public static function view(string $viewName, array $viewData=[]): View
    {
        return new View($viewName, $viewData);
    }
}
