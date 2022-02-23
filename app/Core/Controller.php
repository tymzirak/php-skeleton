<?php

namespace App\Core;

abstract class Controller extends Database {
    static public function view(string $viewName, array $viewData=[]) : View {
        return new View($viewName, $viewData);
    }
}
