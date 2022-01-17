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

            $maxRowNumber = ($this->size[0] - $ship->size);
            $maxColNumber = ($this->size[1] - $ship->size);


            // Je calcul la probabilité de chaque case d'accueillir un bateau
            for ($i=0; $i <= $maxRowNumber; $i++) { 
                
                for ($j=0; $j < $maxColNumber; $j++) {

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
        $probability = 0;

        // Si la coordonée est déjà visitée
        if (in_array($coordinatesCell, $this->arrayVisitedCoordinates)) {
            return false;
        }
        
        $rowOrColumnKey = $orientation == Constants::getHorizontalOrientationShip() ? 1 : 0;

        $directionsByOrientation = Main::getDirectionsByOrientation($orientation);

        foreach ($directionsByOrientation[$orientation] as $direction) {

            // Pour chaque coordonées potentiel du bateau
            for ($i = 0; $i < $ship->size; $i++) {

                $newCoordinates = $this->calculCoordinatesByDirection($coordinatesCell, $direction, $i);

                // Si la coordonnée est hors du board
                if ($newCoordinates[$rowOrColumnKey] < 0 || $newCoordinates[$rowOrColumnKey] >= $this->size[$rowOrColumnKey]) {
                    continue;
                }

                // Si la coordonnée courante a été visité ?
                if (in_array($newCoordinates, $this->arrayVisitedCoordinates)) {
                    continue;
                }

                $probability++;
            }
        }
             
        return $probability;
    }

}