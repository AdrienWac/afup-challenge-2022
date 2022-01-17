<?php

use PHPUnit\Framework\TestCase;
use Battleship\ProbabilityBoard;
use Battleship\Ship;
use Battleship\Constants;

class ProbabilityBoardTest extends TestCase {

    /**
     * @dataProvider providerCalculateProbabilities
     * Test du calcul de probabilité d'une cellule
     *
     * @param array $visitedCoordinates
     * @param array $coordinatesCell
     * @param string $orientation
     * @param bool $expectedResult
     * @return void
     */
    public function testCalculateProbabilities(array $visitedCoordinates, array $coordinatesCell, string $orientation, bool $expectedResult)
    {

        $probabilityBoard = new ProbabilityBoard([5,5]);

        $probabilityBoard->arrayVisitedCoordinates = $visitedCoordinates;

        $ship = new Ship('Test', 2, 1);

        $probabilityValue = $probabilityBoard->canPutAShipInThisCell($ship, $coordinatesCell, $orientation);

        $this->assertEquals($expectedResult, $probabilityValue);

    }


    public function providerCalculateProbabilities(): array
    {
        return [
            [
                [[0, 0], [0, 1]],
                [0,0],
                Constants::getHorizontalOrientationShip(),
                false
            ],
            [
                [[0,2], [0,3]],
                [0, 0],
                Constants::getHorizontalOrientationShip(),
                true
            ],
            [
                [[0,1]],
                [0, 0],
                Constants::getHorizontalOrientationShip(),
                false
            ],
            [
                [[0, 1]],
                [0, 3],
                Constants::getHorizontalOrientationShip(),
                true
            ],
            [
                [[0, 1]],
                [0, 4],
                Constants::getHorizontalOrientationShip(),
                false
            ],
        ];
    }

}