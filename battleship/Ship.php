<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;

class Ship {
    
    public string $name;
    public int $size;
    public int $identifiant;
    private string $state; 
    public array $coordinates = [];

    function __construct(string $name, int $size, int $identifiant) {
        $this->name = $name;
        $this->size = $size;
        $this->identifiant = $identifiant;
        $this->state = Constants::getStateAliveShip();
    }

    public function setCoordinates(array $coordinates) {
        $this->coordinates = $coordinates;
    }

    public function getState() {
        return $this->state;
    }

}