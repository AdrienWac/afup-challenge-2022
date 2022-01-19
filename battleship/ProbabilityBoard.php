<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\GameBoard;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class ProbabilityBoard extends GameBoard{

    public array $ships;
    public array $arrayVisitedCoordinates;


    function __construct(array $size, array $ships, array $arrayVisitedCoordinates)
    {   
        parent::__construct($size);
        $this->ships = $ships;
        $this->arrayVisitedCoordinates = $arrayVisitedCoordinates;
    }

    /**
     * Calcul la probabilité qu'une cellule puisse accueillir un bateau.
     * Prend en compte l'orientation et les cellules déjà visitées
     * 0 => le bateau ne peut être placé
     * 1 => le bateau peut être placé dans une direction
     * 2 => le bateau peut être placé dans les deux directions
     *
     * @param Ship $ship
     * @param array $coordinatesCell
     * @param string $orientation
     * @return integer
     */
    public function calculProbabilitiesValue(Ship $ship, array $coordinatesCell, string $orientation): int
    {
        if (in_array($coordinatesCell, $this->arrayVisitedCoordinates)) {
            return 0;
        }
        
        $rowOrColumnKey = $orientation == Constants::getHorizontalOrientationShip() ? 1 : 0;

        $directionsByOrientation = Main::getDirectionsByOrientation($orientation);

        if (!$this->canPutShipInCell($coordinatesCell, $directionsByOrientation[0])) {
            return 0;
        }

        $probability = 0;

        foreach ($directionsByOrientation as $direction) {

            $probability += $this->calculProbabilitiesValueByDirection($ship, $coordinatesCell, $direction); 

        }
             
        return $probability;
    }

    /**
     * Calcul la probabilité qu'un bateau puisse être sur une case pour une direction donnée
     *
     * @param Ship $ship
     * @param array $coordinatesCell
     * @param string $direction
     * @return integer
     */
    public function calculProbabilitiesValueByDirection(Ship $ship, array $coordinatesCell, string $direction): int
    {
        // Pour chaque coordonées potentiel du bateau
        for ($i = 1; $i < $ship->size; $i++) {

            $newCoordinates = $this->calculCoordinatesByDirection($coordinatesCell, $direction, $i);

            if (!$this->canPutShipInCell($newCoordinates, $direction)) {
                return 0;
            }

        }

        return 1;
    }

    /**
     * Test si une partie d'un bateau peut être déposé sur une case
     *
     * @param array $coordinatesCell
     * @param string $direction right, left, up, down.
     * @return boolean False si la case est en dehors du board ou déjà visitée. True sinon.
     */
    private function canPutShipInCell(array $coordinatesCell, string $direction): bool
    {
        // En fontion de la direction, on peut savoir si on test les colonnes ou les lignes
        $rowOrColumnKey = in_array($direction, [Constants::getLeftDirection(), Constants::getRightDirection()]) ? 1 : 0;

        // Si la coordonnée est hors du board
        if ($coordinatesCell[$rowOrColumnKey] < 0 || $coordinatesCell[$rowOrColumnKey] >= $this->size[$rowOrColumnKey]) {
            return false;
        }

        // Si la coordonnée courante a été visité ?
        if (in_array($coordinatesCell, $this->arrayVisitedCoordinates)) {
            return false;
        }

        return true;

    }

}