<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\GameBoard;
use Battleship\Ship;
use Battleship\Strategy\IStrategy;

class Main
{

    public GameBoard $myGameBoard;
    public array $myShips = [];
    public IStrategy $strategy;

    function __construct(array $sizeBoard)
    {
        $this->myGameBoard = new GameBoard($sizeBoard);
        $this->myShips = self::generateShips();
        $this->placeShipOnGameBoard();
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
        // echo chr(mt_rand(65, 74)), mt_rand(1, 10), "\n";

        echo $this->shootByProbabilityApproach(), "\n";

    }

    /**
     * Génère le tir via une approche de probabilité
     * 
     * @return string Retourne les coordonnées au format [A-J][1-10]
     */
    private function shootByProbabilityApproach(): string
    {

        // Initialise le plateau des probabilités en mode chasse = new ProbabilityBoard ->generateBoard(chasse)
        // Initialise le plateau des probabilités en mode cible = new ProbabilityBoard 
        // Initialise le mode d'attaque(chasse, cible) en chasse
        // Initialise la stack de coordonnées pour un tir = []
        // Initialise le tableau des coordonnées visités = []
        // Initialise le tableau des bateaux restants = generateShips()
        // Initialise le tableau des bateaux touchés

        // Si mode chasse 
            // Recherche la case avec la plus haute probabilité dans le board mode chasse
            // Tir sur cette case

        return 'A1';
    }
    
    /**
     * Traiter le tir ennemi
     *
     * @param string $coordinates Coordonnées du tir ennemi au format ([A-J][1-10])
     * @return void
     */
    public function handlingEnemyFire(string $coordinates): string
    {

        [$rowNumber, $colNumber] = self::translateCoordinatesToArray($coordinates);

        $board = $this->myGameBoard->getBoard();

        $valueEmptyCell = Constants::getValueEmptyCell();

        if ($board[$rowNumber][$colNumber] === Constants::getValueEmptyCell()) {
            return "miss\n";
        }

        $listOfShipById = self::generateListOfShipsById($this->myShips);

        $shipHit = $listOfShipById[$board[$rowNumber][$colNumber]];

        $shipHit->beShot([$rowNumber, $colNumber]);

        $this->myGameBoard->setBoard([$rowNumber, $colNumber], $valueEmptyCell);

        if ($shipHit->getState() === Constants::getStateSunkShip()) {
            
            if (!$this->hasAnyShipsAlive()) {
                return "won\n";
            }

            return "sunk\n"; 

        }

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

        $rangeLetter = range('A', 'J');

        $extractLetterColumn = preg_split('/([1-9]|10)$/', $coordinatesFromScript, -1, PREG_SPLIT_NO_EMPTY);
        $extractNumberRow = preg_split('/^([A-J])/', $coordinatesFromScript, -1, PREG_SPLIT_NO_EMPTY);

        if ($extractLetterColumn === false || $extractNumberRow === false) {
            throw new \Exception(`Impossible de lire la coordonnée {$coordinatesFromScript}`);
        }

        $colNumber = array_search($extractLetterColumn[0], $rangeLetter);

        if ($colNumber === false) {
            throw new \Exception(`Impossible de lire la coordonnée {$coordinatesFromScript}`);
        }

        $rowNumber = (int) $extractNumberRow[0] - 1;

        return [$rowNumber, (int) $colNumber];

    }


    public static function translateCoordinatesToString(array $coordinates): string 
    {
        $result = '';

        return '';
    }

    /**
     * Retourne la liste des bateaux avec l'identifiant en clé 
     *
     * @param array $arrayOfShips
     * @return array
     */
    public static function generateListOfShipsById(array $arrayOfShips): array
    {
        $arrayColumn = array_column($arrayOfShips, 'identifiant');

        return array_combine($arrayColumn, array_values($arrayOfShips));

    }

    public function hasAnyShipsAlive(): bool
    {

        $listOfShipState = array_column($this->myShips, 'state');

        return in_array(Constants::getStateAliveShip(), $listOfShipState);

    }

    /**
     * Retourne le tableau des directions pour une orientation
     * Si $orientation est null retourne les directions pour toutes les orientations.
     * @param string|null $orientation
     * @return array Tableau des directions
     */
    public static function getDirectionsByOrientation(?string $orientation = null): array
    {
        $arrayDirections = [
            Constants::getHorizontalOrientationShip() => [Constants::getLeftDirection(), Constants::getRightDirection()],
            Constants::getVerticalOrientationShip() => [Constants::getUpDirection(), Constants::getDownDirection()]
        ];

        if (is_null($orientation)) {
            return $arrayDirections;
        }

        return $arrayDirections[$orientation];
    }

}
