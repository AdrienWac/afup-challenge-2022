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

    /**
     * Test all ships should be placed into the board
     *
     * @return void
     */
    public function testPlaceShipsOnGameBoard() {
        
        $game = new Game([10, 10]);

        $game->placeShipOnGameBoard();

        $myGameBoard = $game->myGameBoard;
        
        $countCaseOfShip = array_sum(

            array_map(function($array) {

                $countValueOfArray = array_count_values($array);

                if (array_key_exists('X', $countValueOfArray)) {
                    return $countValueOfArray['X'];
                }

                return 0;

            }, $myGameBoard->getBoard())

        );

        $this->assertEquals($countCaseOfShip, 17);
        
    }

}