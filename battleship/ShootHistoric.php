<?php 

namespace Battleship;

require "vendor/autoload.php";

class ShootHistoric {

    public \SPLDoublyLinkedList $stackShootHistoric;

    public function __construct()
    {
        $this->stackShootHistoric = new \SplStack();        
    }

    public function addShootToHistoric(array $shootInformations): void
    {
        $this->stackShootHistoric->unshift($shootInformations);
    }

    public function setPropertyOfLastShootInHistoric(string $property, mixed $valueProperty): void
    {
        $shoot = $this->stackShootHistoric->offsetGet(0);

        $shoot[$property] = $valueProperty;

        $this->stackShootHistoric->offsetSet(0, $shoot);

    }




}