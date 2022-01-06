<?php

use PHPUnit\Framework\TestCase;
use Battleship\GameBoard;

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

    

}