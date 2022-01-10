<?php

use PHPUnit\Framework\TestCase;
use Battleship\Game;
use Battleship\Ship;

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
     * @dataProvider providerTestTranslateCoordinates
     * Test traduction des coordonnées
     *
     * @return void
     */
    public function testTranslateCoordinatesToArray(string $coordinates, array $expectedResult)
    {
        $result = Game::translateCoordinatesToArray($coordinates);

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

        $listOfShips = Game::generateListOfShipsById(['testA' => $shipA, 'testB' => $shipB]);
        
        $expectedResult = [1 => $shipA, 2 => $shipB ];

        $this->assertEquals($expectedResult, $listOfShips);

    }

    public function testHandlingEnemyFireHitAShip()
    {
        // Initialisation du jeu
        $game = $this->initGameForHandlingEnemyFireTest();

        // Tirer sur une case du bateau
        $resultEnemyFire = $game->handlingEnemyFire('A1');

        // Tester que l'on retourne bien Hit
        $this->assertEquals("hit\n", $resultEnemyFire);
    }

    /**
     * Initialisation du jeu pour les tests de traitement du tir enemi
     *
     * @return Game
     */
    private function initGameForHandlingEnemyFireTest(): Game
    {
        $game = new Game([5,5]);

        $ship = new Ship('Test', 2, 1);

        foreach ($arrayShipPositions = [[0,0], [0,1]] as $coordinates) {

            $game->myGameBoard->setBoard($coordinates, $ship->identifiant);

        }

        $ship->coordinates = $arrayShipPositions;

        $game->myShips = [$ship];

        return $game;

    }

    

    public function handlingEnemyFireSunkAShip()
    {
        // Créer le jeu

        // Créer un bateau de taille 1

        // Placer le bateau

        // Tirer sur la case du bateau

        // Tester que l'on retourne bien Sunk
    }

    public function handlingEnemyFireMissShot()
    {
        // Créer le jeu

        // Créer un bateau de taille 1

        // Placer le bateau

        // Tirer sur la case du bateau

        // Tester que l'on retourne bien Miss
    }


}