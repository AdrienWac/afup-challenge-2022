<?php

namespace Battleship\Strategy;

require "vendor/autoload.php";

use Battleship\Main;
use Battleship\ProbabilityBoard;
use Battleship\Ship;
use Battleship\Strategy\IStrategy;

/**
 * Stratégie de cible après un tir réussi
 */
class TargetStrategy implements IStrategy
{

    public ProbabilityBoard $probabilityBoard;

    public function __construct(public array $size = [10, 10], public array &$ships, public array &$arrayCellsVisited = [], public array $coordinatesTargetCell)
    {
        $this->size = $size;
        $this->ships = $ships;
        $this->arrayCellsVisited = $arrayCellsVisited;
        $this->coordinatesTargetCell = $coordinatesTargetCell;
    }

    public function shoot(): array
    {
        return [0, 0];
    }

    public function generateBoard(): ProbabilityBoard
    {
        
        $this->probabilityBoard = new ProbabilityBoard($this->size, $this->ships, $this->arrayCellsVisited);
        // On calcul la probabilité des cases autour de la case cible

        // Init le tableau des directions par les orientations Main::getDirectionsByOrientation(null)
        $arrayDirectionsByOrientation = Main::getDirectionsByOrientation();

        // Pour chaque bateau $ships
        foreach ($this->ships as $ship) {
            
            $ship->size--;

            foreach ($arrayDirectionsByOrientation as $orientation => $arrayDirections) {
                
                foreach ($arrayDirections as $direction) {

                    $newCoordinates = $this->probabilityBoard->calculCoordinatesByDirection($this->coordinatesTargetCell, $direction, 1);
                    $probabilityValue = $this->probabilityBoard->calculProbabilitiesValue($ship, $newCoordinates, $orientation);
                    if ($probabilityValue > 0) {
                        $this->probabilityBoard->board[$newCoordinates[0]][$newCoordinates[1]] += $probabilityValue;
                    }


                }

            }

        }
            // Pour chaque orientation
                // Pour chaque direction 
                    // Calcul de la nouvelle coordonnée calculCoordinatesByDirection($direction, $coordinatesTargetCell, 1)
                    // Calcul de la probabilité de la case courante d'acceuillir le bateau courant $ship calculProbabilitiesValue(Ship $ship, array $coordinatesCell, string $orientation)
                    // Mise à jour de la case du board
                // Fin Pour
            // Fin pour
        // Fin pour
        return $this->probabilityBoard;
    }

    /**
     * Extrait la cellule 
     *
     * @param ProbabilityBoard $board
     * @return array
     */
    public function extractCoordinatesCellWithHighestProbability(ProbabilityBoard $board): array
    {

        // Si mode 

        return [0, 0];
    }



}
