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
     * Génère le plateau de jeu des probabilités
     *
     * @return void
     */
    public function generateBoard(): void
    {

        // Pour chaque bateaux
        foreach ($this->ships as $ship) {

            // Je calcul la probabilité de chaque case d'accueillir un bateau
            for ($i=0; $i < $this->size[0]; $i++) { 
                
                for ($j=0; $j < $this->size[1]; $j++) {

                    foreach ([Constants::getHorizontalOrientationShip(), Constants::getVerticalOrientationShip()] as $orientation) {

                        $this->board[$i][$j] += $this->calculProbabilitiesValue($ship, [$i, $j], $orientation);

                    }

                }

            }

        }
        
    }

    /**
     * Calcul la probabilité qu'une cellule puisse être le point de départ du placement d'un bateau.
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