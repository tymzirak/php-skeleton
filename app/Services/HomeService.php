<?php

namespace App\Services;

class HomeService {
    private $greetings = ["hello", "hi", "welcome"];

    public function getRandomGreeting() : string {
        return $this->greetings[array_rand($this->greetings)];
    }
}
