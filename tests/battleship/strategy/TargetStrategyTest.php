<?php

use PHPUnit\Framework\TestCase;
use Battleship\Ship;
use Battleship\Strategy\TargetStrategy;


class TargetStrategyTest extends TestCase {

    /**
     * 
     * Test généréation board de probabilité en mode cible
     *
     * @return void
     */
    public function testGenerateBoard(): void
    {
        $arrayShips = [new Ship('TestA', 2, 1)];
        
        $coordinatesTargetCell = [0,0];

        $arrayCellVisited = [[0,1]];

        $targetStrategy = new TargetStrategy([3,5], $arrayShips, $arrayCellVisited, $coordinatesTargetCell);

        $expectedResult = [
            [0, 0, 0, 0, 0],
            [1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
        ];

        $this->assertEquals($expectedResult, $targetStrategy->generateBoard()->board);

    }

}