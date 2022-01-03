<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\GameBoard;
use Battleship\Boat;

class Game
{

    public GameBoard $myGameBoard;
    public array $myShips = [];

    function __construct(array $sizeBoard)
    {
        $this->myGameBoard = new GameBoard($sizeBoard, null);
        $this->myShips['AircraftCarrier'] = new Boat('AircraftCarrier', 5);
        $this->myShips['Cruiser'] = new Boat('Cruiser', 4);
        $this->myShips['Destroyer1'] = new Boat('Destroyer1', 3);
        $this->myShips['Destroyer2'] = new Boat('Destroyer2', 3);
        $this->myShips['TorpedoBoat'] = new Boat('Torpedo Boat', 2);
    }

    public function placeShipOnGameBoard()
    {
        // Pour chaque bateau
            // Si premier bateau 
                // Get random position on board

    }


    public function getBoard()
    {
        return $this->board;
    }
}
