<?php

use PHPUnit\Framework\TestCase;
use Battleship\GameBoard;
use Battleship\Ship;
use Battleship\Game;

class GameBoardTest extends TestCase {

    public function testIsAvailableCellReturnTrue() {
        
        $gameBoard = new GameBoard([10, 10]);

        $gameBoard->setBoard([0,1], 'X');

        $this->assertTrue($gameBoard->isAvailableCell([0,0]));

    }

    public function testGetOccupiedCellsWithEmptyBoard() {

        $gameBoard = new GameBoard([10,10]);

        $this->assertCount(0, $gameBoard->getOccupiedCells());     

    }

    public function testGetOccupiedCellsWithOneShipOneBoard() {

        $gameBoard = new GameBoard([10,10]);

        $gameBoard->setBoard([0,1], 'test');

        $this->assertCount(1, $gameBoard->getOccupiedCells());

    }

    public function testFindRandomAvailableCellCoordinates() {
        
        $gameBoard = new GameBoard([2, 3]);

        $ship = new Ship('test', 1, 1);

        $arrayCellVisited = [[1,1]];

        $arrayCellOcupped = [[0, 0], [0, 1], [0, 2], [1, 0]];

        foreach ($arrayCellOcupped as $coordinates) {
            $gameBoard->setBoard($coordinates, 'test');
        }

        $arrayCellVisitedAndOccuped = [...$arrayCellVisited, ...$arrayCellOcupped];

        $result = $gameBoard->findRandomAvailableCellCoordinates($ship, $arrayCellVisitedAndOccuped);

        $this->assertEquals($result, [1,2]);

    }

    public function testFindRandomAvailableCellCoordinatesAddToArrayCellVisited() {
        
        $gameBoard = new GameBoard([2, 3]);

        $ship = new Ship('test', 1, 1);

        $arrayCellVisited = [[1,1], [0, 0], [0, 1], [0, 2], [1, 0]];

        $gameBoard->setBoard([0, 0], 'test');
        $gameBoard->setBoard([0, 1], 'test');
        $gameBoard->setBoard([0, 2], 'test');
        $gameBoard->setBoard([1, 0], 'test');

        $gameBoard->findRandomAvailableCellCoordinates($ship, $arrayCellVisited);

        $this->assertEquals($arrayCellVisited, [[1, 1], [0, 0], [0, 1], [0, 2], [1, 0], [1,2]]);

    }

    // public function testFindRandomAvailableCellCoordinatesFullBoard() {

    // }

    public function testTryPlaceShipFromPoint() {

        $gameBoard = new GameBoard([3,3]);

        $arrayCellOcupped = [[0, 0], [0, 1], [0, 2], [1, 0], [2,0], [2,1], [2,2]];

        foreach ($arrayCellOcupped as $coordinates) {
            $gameBoard->setBoard($coordinates, 'test');
        }

        $ship = new Ship('test', 2, 1);

        $arrayCellVisited = $arrayCellOcupped;

        $exceptedResult = $gameBoard->tryPlaceShipFromPoint($ship, [1,1], $arrayCellVisited);

        $this->assertEquals($exceptedResult, [[1,1], [1,2]]);

    }
    
    public function testPlaceShipsOnBoard() 
    {

        for ($i=0; $i < 250; $i++) {

            $arrayShips = Game::generateShips();

            $exceptedResult = array_combine(array_column($arrayShips, 'identifiant'), array_column($arrayShips, 'size'));

            $gameBoard = new GameBoard([10, 10]);

            

            $gameBoard->placeShipsOnBoard($arrayShips);

            $sumFinal = array_fill_keys(array_keys($exceptedResult), 0);

            foreach ($board = $gameBoard->getBoard() as $row) {

                foreach ($row as $value) {

                    if (array_key_exists($value, $sumFinal)) {
                        $sumFinal[$value]++;
                    }
                }

            }

            $this->assertEquals($exceptedResult, $sumFinal);

        }

    }

    

}