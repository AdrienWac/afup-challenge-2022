<?php

namespace Battleship\Strategy;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\ProbabilityBoard;
use Battleship\Strategy\IStrategy;

/**
 * Stratégie de chasse
 */
class HuntStrategy implements IStrategy
{

    public ProbabilityBoard $probabilityBoard;

    public function __construct(public array $size = [10,10], public array &$ships = [], public array &$arrayCellsVisited = [])
    {
        $this->size = $size;
        $this->ships = $ships;
        $this->arrayCellsVisited = $arrayCellsVisited;
    }

    public function shoot(): array
    {
        return [0,0];
    }

    /**
     * Génére un board des probabilités en mode chasse.
     * 
     *
     * @return ProbabilityBoard
     */
    public function generateBoard(): ProbabilityBoard
    {

        $this->probabilityBoard = new ProbabilityBoard($this->size, $this->ships, $this->arrayCellsVisited);

        // Pour chaque bateaux
        foreach ($this->ships as $ship) {

            // Je calcul la probabilité de chaque case d'accueillir un bateau
            for ($i = 0; $i < $this->size[0]; $i++) {

                for ($j = 0; $j < $this->size[1]; $j++) {

                    foreach ([Constants::getHorizontalOrientationShip(), Constants::getVerticalOrientationShip()] as $orientation) {

                        $this->probabilityBoard->board[$i][$j] += $this->probabilityBoard->calculProbabilitiesValue($ship, [$i, $j], $orientation);
                    }
                }
            }
        }

        return $this->probabilityBoard;

    }

    public function extractCoordinatesCellWithHighestProbability(ProbabilityBoard $board): array
    {
        return [0,0];
    }

}


