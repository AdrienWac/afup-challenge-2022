<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\GameBoard;
use Battleship\Ship;

class Game
{

    public GameBoard $myGameBoard;
    public array $myShips = [];

    function __construct(array $sizeBoard)
    {
        $this->myGameBoard = new GameBoard($sizeBoard, 0);
        $this->myShips['AircraftCarrier'] = new Ship('AircraftCarrier', 5, 1);
        $this->myShips['Cruiser'] = new Ship('Cruiser', 4, 2);
        $this->myShips['Destroyer1'] = new Ship('Destroyer1', 3, 3);
        $this->myShips['Destroyer2'] = new Ship('Destroyer2', 3, 4);
        $this->myShips['TorpedoBoat'] = new Ship('Torpedo Boat', 2, 5);
    }

    public function placeShipOnGameBoard()
    {
        $this->myGameBoard->setBoard([0,0], 'X');
        $this->myGameBoard->setBoard([0,1], 'X');
        $this->myGameBoard->setBoard([0,2], 'X');
        $this->myGameBoard->setBoard([0,3], 'X');
        $this->myGameBoard->setBoard([0,4], 'X');


        $this->myGameBoard->setBoard([0, 5], 'X');
        $this->myGameBoard->setBoard([0, 6], 'X');
        $this->myGameBoard->setBoard([0, 7], 'X');
        $this->myGameBoard->setBoard([0, 8], 'X');

        $this->myGameBoard->setBoard([1, 0], 'X');
        $this->myGameBoard->setBoard([1, 1], 'X');
        $this->myGameBoard->setBoard([1, 2], 'X');

        $this->myGameBoard->setBoard([1, 3], 'X');
        $this->myGameBoard->setBoard([1, 4], 'X');
        $this->myGameBoard->setBoard([1, 5], 'X');

        $this->myGameBoard->setBoard([1, 6], 'X');
        $this->myGameBoard->setBoard([1, 7], 'X');

    }

    


    public function getBoard()
    {
        return $this->board;
    }
}
