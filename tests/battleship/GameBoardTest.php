<?php

use PHPUnit\Framework\TestCase;
use Battleship\GameBoard;
use Battleship\Ship;

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

        $gameBoard->setBoard([0, 0], 'test');
        $gameBoard->setBoard([0, 1], 'test');
        $gameBoard->setBoard([0, 2], 'test');
        $gameBoard->setBoard([1, 0], 'test');

        $result = $gameBoard->findRandomAvailableCellCoordinates($ship, $arrayCellVisited);

        $this->assertEquals($result, [1,2] );

    }

    public function testFindRandomAvailableCellCoordinatesAddToArrayCellVisited() {
        
        $gameBoard = new GameBoard([2, 3]);

        $ship = new Ship('test', 1, 1);

        $arrayCellVisited = [[1,1]];

        $gameBoard->setBoard([0, 0], 'test');
        $gameBoard->setBoard([0, 1], 'test');
        $gameBoard->setBoard([0, 2], 'test');
        $gameBoard->setBoard([1, 0], 'test');

        $gameBoard->findRandomAvailableCellCoordinates($ship, $arrayCellVisited);

        $this->assertEquals($arrayCellVisited, [[1,1], [1,2]]);

    }

    // public function testFindRandomAvailableCellCoordinatesFullBoard() {

    // }

    

}