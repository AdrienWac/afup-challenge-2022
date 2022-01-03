<?php

use PHPUnit\Framework\TestCase;
use Battleship\Game;

class GameTest extends TestCase {

    public function testConstructGame() {
        
        $game = new Game([10,10]);
        $this->assertEquals(["AircraftCarrier", "Cruiser", "Destroyer1", "Destroyer2", "TorpedoBoat"], array_keys($game->myShips));

        $myGameBoard = $game->myGameBoard;
        $this->assertEquals(
            [
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null]
            ],
            $myGameBoard->getBoard()
        );

    }

    public function testPlaceShipsOnGameBoard() {
        
        $game = new Game([10, 10]);

        $game->placeShipOnGameBoard();

        $myGameBoard = $game->myGameBoard;
        
        // TODO compter le nombre de X dans le board
        $this->assertEquals(
            [
                [null, 'X', 'X', 'X', 'X', 'X', null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null, null]
            ],
            $myGameBoard->getBoard()
        );
    

    }

}