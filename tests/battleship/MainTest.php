<?php

use PHPUnit\Framework\TestCase;
use Battleship\Main;
use Battleship\Ship;

class MainTest extends TestCase {

    public function testConstructGame() {
        
        $game = new Main([10,10]);
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
     * @dataProvider providerTestTranslateCoordinates
     * Test traduction des coordonnées
     *
     * @return void
     */
    public function testTranslateCoordinatesToArray(string $coordinates, array $expectedResult)
    {
        $result = Main::translateCoordinatesToArray($coordinates);

        $this->assertEquals($expectedResult, $result);

    }


    public function providerTestTranslateCoordinates(): array
    {
        return [
            [
                'D10',
                [9,3]
            ],
            [
                'A1',
                [0,0]
            ],
            [
                'E8',
                [7,4]
            ]
        ];
    }

    
    public function testGenerateListOfShipsById()
    {   
        
        $shipA = new Ship('testA', 2, 1);
        $shipB = new Ship('testB', 2, 2);

        $listOfShips = Main::generateListOfShipsById(['testA' => $shipA, 'testB' => $shipB]);
        
        $expectedResult = [1 => $shipA, 2 => $shipB ];

        $this->assertEquals($expectedResult, $listOfShips);

    }


    /**
     * @dataProvider providerEnnemyFire
     *
     * @return void
     */
    public function testHandlingEnemyFire(array $arrayShotsCoordinates, string $expectedResult)
    {
        // Initialisation du jeu
        $game = $this->initGameForHandlingEnemyFireTest();

        // Tirer sur une case du bateau
        foreach ($arrayShotsCoordinates as $shotCoordinates) {
            $resultEnemyFire = $game->handlingEnemyFire($shotCoordinates);
        }

        // Tester que l'on retourne bien Hit
        $this->assertEquals($expectedResult, $resultEnemyFire);
    }

    /**
     * Provider to test the handller method of ennemy fire 
     *
     * @return array
     */
    public function providerEnnemyFire(): array 
    {
        return [
            [
                ['A1', 'A1'],
                "miss\n"
            ],
            [
                ['A1'],
                "hit\n"
            ],
            [
                ['A1', 'B1'],
                "sunk\n"
            ],
            [
                ['B1', 'A1'],
                "sunk\n"
            ],
            [
                ['B1', 'A1', 'D5', 'E5'],
                "won\n"
            ],
            [
                ['B2'],
                "miss\n"
            ]
        ];
    }


    /**
     * Initialisation du jeu pour les tests de traitement du tir enemi
     *
     * @return Main
     */
    private function initGameForHandlingEnemyFireTest(): Main
    {
        $game = new Main([5,5]);
        $game->myShips = [];
        $shipA = new Ship('TestA', 2, 1);
        $shipB = new Ship('TestB', 2, 2);

        $arrayShipPositions = [1 => [[0, 0], [0, 1]], 2 => [[4, 3], [4, 4]]];

        foreach ([$shipA, $shipB] as $ship) {

            foreach ($arrayShipPositions[$ship->identifiant] as $coordinates) {
                
                $game->myGameBoard->setBoard($coordinates, $ship->identifiant);

            }

            $ship->coordinates = $arrayShipPositions[$ship->identifiant];

            $game->myShips[$ship->name] = $ship;

        }

        return $game;

    }


}