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
     * @param int $expectedResult
     * @return void
     */
    public function testCalculateProbabilities(array $visitedCoordinates, array $coordinatesCell, string $orientation, int $expectedResult)
    {

        $ship = new Ship('Test', 2, 1);

        $probabilityBoard = new ProbabilityBoard([5,5], [$ship], $visitedCoordinates);

        $probabilityBoard->arrayVisitedCoordinates = $visitedCoordinates;

        $probabilityValue = $probabilityBoard->calculProbabilitiesValue($ship, $coordinatesCell, $orientation);

        $this->assertEquals($expectedResult, $probabilityValue);

    }


    public function providerCalculateProbabilities(): array
    {
        return [
            [
                [[0, 0], [0, 1]],
                [0,0],
                Constants::getHorizontalOrientationShip(),
                0
            ],
            [
                [[0, 1]],
                [0, 0],
                Constants::getHorizontalOrientationShip(),
                0
            ],
            [
                [],
                [0, 1],
                Constants::getHorizontalOrientationShip(),
                2
            ]
        ];
    }

}