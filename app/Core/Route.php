<?php

namespace App\Core;

class Route
{
    private string $namespace = "App\Controller\\";
    private object|string $controller;
    private $action;
    private array $params;

    private static array $resources = [];

    public function __construct()
    {
        $this->useRoute();
    }

    private function useRoute()
    {
        $url = empty($_GET["url"]) ? "" : trim($_GET["url"], "/");

        foreach (self::$resources as $route => $options) {
            if ($this->validateRoute($url, $route)) {
                $params = $this->getRouteParams($url, $route);
                if ($this->execRoute($options["action"], $params, $options["request_method"])) {
                    return;
                }
            }
        }

        throw new \Exception("Route not found.");
    }

    private function validateRoute(string $url, string $route): bool
    {
        $pattern = "/^" . str_replace(["{}", "/"], ["\w+", "\/"], $route) . "$/";

        return preg_match($pattern, $url);
    }

    private function getRouteParams(string $url, string $route): array
    {
        $params = [];
        $urlPieces = explode("/", $url);
        $routePieces = explode("/", $route);
        for ($p = 0; $p < count($routePieces); $p++) {
            if ($routePieces[$p] == "{}") {
                $params[] = $urlPieces[$p];
            }
        }

        return $params;
    }

    private function execRoute($action, array $params, string $requestMethod): bool
    {
        if ($_SERVER["REQUEST_METHOD"] != strtoupper($requestMethod)) {
            return false;
        }

        if (gettype($action) == "string") {
            $actionPieces = explode("@", $action);

            $this->controller = $actionPieces[0];
            $this->action = $actionPieces[1];
            $this->params = $params;

            return $this->execController();
        }

        $action(...$params);

        return true;
    }

    private function execController(): bool
    {
        $controller = $this->namespace . $this->controller;
        if (class_exists($controller)) {
            $this->controller = new $controller;
            if (method_exists($this->controller, $this->action)) {
                call_user_func_array([$this->controller, $this->action], $this->params);
                return true;
            }
        }

        return false;
    }

    public static function setRoute(string $route, $action, string $requestMethod="GET")
    {
        self::$resources[trim($route, "/")] = [
            "action" => $action,
            "request_method" => $requestMethod
        ];
    }
}
