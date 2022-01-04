<?php

namespace Battleship;

require "vendor/autoload.php";

class Boat {
    
    public string $name;
    public int $size;
    public int $identifiant;
    public array $coordinates = [];

    function __construct(string $name, int $size, int $identifiant) {
        $this->name = $name;
        $this->size = $size;
        $this->identifiant = $identifiant;
    }

    public function setCoordinates(array $coordinates) {
        $this->coordinates = $coordinates;
    }

}