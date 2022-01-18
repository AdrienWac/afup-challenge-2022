<?php

use Battleship\ProbabilityBoard;
use Battleship\Ship;
use Battleship\Strategy\IStrategy;

/**
 * Stratégie de cible après un tir réussi
 */
class TargetStrategy implements IStrategy
{

    public ProbabilityBoard $probabilityBoard;

    public function __construct(public array $size = [10, 10], public array &$ships, public array &$arrayCellsVisited = [], public array $coordinatesTargetCell = [0,0])
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
        // On calcul la probabilité des cases autour de la case cible

        // Init le tableau des directions par les orientations Main::getDirectionsByOrientation(null)

        // Pour chaque bateau $ships
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
