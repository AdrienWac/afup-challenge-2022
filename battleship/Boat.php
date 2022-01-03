<?php

namespace Battleship;

require "vendor/autoload.php";

class Boat {
    
    public string $name;
    public int $size;
    public array $coordinates = [];

    function __construct(string $name, int $size) {
        $this->name = $name;
        $this->size = $size;
    }

    public function setCoordinates(array $coordinates) {
        $this->coordinates = $coordinates;
    }

}