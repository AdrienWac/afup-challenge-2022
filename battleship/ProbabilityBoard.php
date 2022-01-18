<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\GameBoard;

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

        $canPutShipInCell = function($coordinatesCell) use($rowOrColumnKey) {
            
            // Si la coordonnée est hors du board
            if ($coordinatesCell[$rowOrColumnKey] < 0 || $coordinatesCell[$rowOrColumnKey] >= $this->size[$rowOrColumnKey]) {
                return false;
            }

            // Si la coordonnée courante a été visité ?
            if (in_array($coordinatesCell, $this->arrayVisitedCoordinates)) {
                return false;
            }

            return true;

        };

        if (!$canPutShipInCell($coordinatesCell)) {
            return 0;
        }

        $probability = 0;

        foreach ($directionsByOrientation as $direction) {

            // Pour chaque coordonées potentiel du bateau
            for ($i = 1; $i < $ship->size; $i++) {

                $newCoordinates = $this->calculCoordinatesByDirection($coordinatesCell, $direction, $i);

                if(!$canPutShipInCell($newCoordinates)) {
                    continue 2;     
                }

            }

            $probability++;

        }
             
        return $probability;
    }

}