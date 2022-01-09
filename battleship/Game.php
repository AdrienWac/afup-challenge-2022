<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\GameBoard;
use Battleship\Ship;

class Game
{

    public GameBoard $myGameBoard;
    public array $myShips = [];

    function __construct(array $sizeBoard)
    {
        $this->myGameBoard = new GameBoard($sizeBoard);
        $this->myShips = self::generateShips();
    }

    public function placeShipOnGameBoard()
    {
        $this->myGameBoard->placeShipsOnBoard($this->myShips);
    }

    /**
     * Génère une flotte de bateau pour jouer
     *
     * @return array Tableau des bateaux
     */
    public static function generateShips(): array
    {
        return [
            'AircraftCarrier' => new Ship('AircraftCarrier', 5, 1),
            'Cruiser' => new Ship('Cruiser', 4, 2),
            'Destroyer1' => new Ship('Destroyer1', 3, 3),
            'Destroyer2' => new Ship('Destroyer2', 3, 4),
            'TorpedoBoat' => new Ship('Torpedo Boat', 2, 5),
        ];
    }

    public function getBoard()
    {
        return $this->myGameBoard;
    }

    /**
     * Tir sur le board ennemi
     *
     * @return void
     */
    public function shoot(): void
    {
        echo chr(mt_rand(65, 74)), mt_rand(1, 10), "\n";
    }

    /**
     * Traiter le tir ennemi
     *
     * @param string $coordinates Coordonnées du tir ennemi au format ([A-J][1-10])
     * @return void
     */
    public function handlingEnemyFire(string $coordinates): string
    {
        [$rowNumber, $colNumber] = $this->translateCoordinates($coordinates);
        // Translate coordinates
        $board = $this->myGameBoard->getBoard();

        if ($board[$rowNumber][$colNumber] === Constants::getValueEmptyCell()) {
            return "miss\n";
        }

        // Récupérer le ship par la valeur de la case et $this->myShips

        // Retirer la coordonnée de $this->myShips[value cell]->positions

        // Si le $this->myShips[value cell]->positions est vide 
            // return "sunk\n"; 

        // Modifier la valeur de la cell du board par Constants::getValueEmptyCell()

        return "hit\n";
    }

    /**
     * Transforme les coordonnées du type "CL" ^
     * - C: la colonne peut être égal à [A-J]
     * - L: la ligne qui peut être égale à [1-10]
     * En tableau du type [[0-9]Row, [0-9]Col]
     *
     * @param string $coordinatesFromScript  Coordonnées au format [[A-J]Col][[1-10]Row] 
     * @return array Coordonnées au format [[0-9]Row, [0-9]Col]
     */
    public static function translateCoordinatesToArray(string $coordinatesFromScript): array
    {
        $result = [9,3];

        return $result;
    }


    public static function translateCoordinatesToString(array $coordinates): string 
    {
        $result = '';

        return '';
    }

}
