<?php

namespace App\Core;

class View {
    private $viewFile;
    private $viewData;

    public function __construct(string $viewFile, array $viewData) {
        $this->execView($viewFile, $viewData);
    }

    private function execView(string $viewFile, array $viewData) : bool {
        $this->viewFile = str_replace(".", DIRECTORY_SEPARATOR, $viewFile);
        $this->viewData = $viewData;
        if (file_exists(VIEWS . $this->viewFile . ".phtml")) {
            extract($this->viewData);
            include VIEWS . $this->viewFile . ".phtml";
            return true;
        } return false;
    }
}
