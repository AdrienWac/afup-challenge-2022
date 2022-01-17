<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\GameBoard;

class ProbabilityBoard extends GameBoard{

    public array $ships;
    public array $arrayVisitedCoordinates;


    function __construct(array $size)
    {   
        parent::__construct($size);
    }

    /**
     * Test si on peut poser un navire à partir d'une cellule.
     * Retourne faux si le bateau passe pas, ou si une des cases a déjà été visité
     * 
     * @return int
     */
    public function canPutAShipInThisCell(Ship $ship, array $coordinatesCell, string $orientation): bool
    {

        // Si la coordonée est déjà visitée
        if (in_array($coordinatesCell, $this->arrayVisitedCoordinates)) {
            return false;
        }
        
        // Si le bateau ne passe pas dans le board
        $rowOrColumnKey = $orientation == Constants::getHorizontalOrientationShip() ? 1 : 0;
        if ($coordinatesCell[$rowOrColumnKey] + ($ship->size - 1) < 0 &&  $coordinatesCell[$rowOrColumnKey] + ($ship->size - 1) >= $this->size[$rowOrColumnKey]) {
            return false;
        }
        
        // Pour chaque coordonées potentiel du bateau
        for ($i=0; $i < $ship->size; $i++) { 

            // Si la coordonnée est hors du board
            if ($coordinatesCell[$rowOrColumnKey] + $i < 0 || $coordinatesCell[$rowOrColumnKey] + $i >= $this->size[$rowOrColumnKey]) {
                return false;
            }

            // Si la coordonnée courante a été visité ?
            $newCoordinates = $orientation == Constants::getHorizontalOrientationShip() ?  [$coordinatesCell[0], $coordinatesCell[1] + $i] : [$coordinatesCell[0] + $i, $coordinatesCell[1]];
            if (in_array($newCoordinates, $this->arrayVisitedCoordinates)) {
                return false;
            }

        }
             
        return true;
    }

}