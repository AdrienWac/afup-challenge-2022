<?php

use PHPUnit\Framework\TestCase;
use Battleship\GameBoard;

class GameBoardTest extends TestCase {

    public function testIsAvailableCellReturnTrue() {
        
        $gameBoard = new GameBoard([10, 10], null);

        $gameBoard->setBoard([0,1], 'X');

        $this->assertTrue($gameBoard->isAvailableCell([0,0]));

    }

    

}