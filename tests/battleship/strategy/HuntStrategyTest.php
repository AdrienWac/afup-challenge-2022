<?php

use PHPUnit\Framework\TestCase;
use Battleship\Ship;
use Battleship\Constants;
use Battleship\Strategy\HuntStrategy;

class HuntStrategyTest extends TestCase
{


    /**
     * @dataProvider providerGenerateBoard
     * Test de génération du board de probabilité
     *
     * @param array $arrayShips
     * @param array $visitedCoordinates
     * @param array $expectedResult
     * @return void
     */
    public function testGenerateBoard(array $arrayShips, array $visitedCoordinates, array $expectedResult)
    {
        $huntStrategy = new HuntStrategy([3, 5], $arrayShips, $visitedCoordinates);

        $this->assertEquals($expectedResult, $huntStrategy->generateBoard()->board);
    }


    public function providerGenerateBoard(): array
    {

        $generateArrayShip = function (...$arrayShipInformation) {

            $result = [];

            foreach ($arrayShipInformation as $shipInformation) {

                $result[] = new Ship($shipInformation['name'], $shipInformation['size'], $shipInformation['identifiant']);
            }

            return $result;
        };


        return [
            [

                $generateArrayShip(['name' => 'Test', 'size' => 2, 'identifiant' => 0]),
                [],
                [
                    [2, 3, 3, 3, 2],
                    [3, 4, 4, 4, 3],
                    [2, 3, 3, 3, 2],
                ]

            ],
            [

                $generateArrayShip(['name' => 'Test', 'size' => 2, 'identifiant' => 0], ['name' => 'TestB', 'size' => 2, 'identifiant' => 2]),
                [],
                [
                    [4, 6, 6, 6, 4],
                    [6, 8, 8, 8, 6],
                    [4, 6, 6, 6, 4],
                ]

            ],
            [

                $generateArrayShip(['name' => 'Test', 'size' => 2, 'identifiant' => 0]),
                [[0, 0]],
                [
                    [0, 2, 3, 3, 2],
                    [2, 4, 4, 4, 3],
                    [2, 3, 3, 3, 2],
                ]

            ],
        ];
    }

}
