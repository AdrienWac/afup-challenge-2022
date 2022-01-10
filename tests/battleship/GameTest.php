<?php

use PHPUnit\Framework\TestCase;
use Battleship\Game;

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


}