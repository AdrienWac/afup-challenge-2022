<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;

class GameBoard {

    public array $size;
    private array $board;
    private array $ships;

    function __construct(array $size)
    {   
        $this->size = $size;
        [$numberMaxRow, $numberMaxCol] = $size;
        $this->board = array_fill(0, $numberMaxRow, array_fill(0, $numberMaxCol, Constants::getValueEmptyCell()));
    }

    /**
     * Get the current game board
     *
     * @return array
     */
    public function getBoard(): array {
        return $this->board;
    }

    /**
     * Set cell value of game board
     *
     * @param array $coordinates Table coordinates of cell
     * @param mixed $value New value for cell
     * @return void
     */
    public function setBoard(array $coordinates, mixed $value) {
        [$rowNumber, $colNumber] = $coordinates;
        $this->board[$rowNumber][$colNumber] = $value;
    }

    /**
     * Helper method to visualize game board
     *
     * @return void
     */
    public function draw()
    {

        $result = [];

        array_map(function ($array) use (&$result) {
            $result[] = implode('', $array);
        }, $this->board);

        print_r($result);

    }
    
    /**
     * Place randomly ships on board
     *
     * @param array $ships Array of ships to place
     * @return void
     */
    public function placeShipsOnBoard(array $ships) {

        $arrayOccupiedCells = $this->getOccupiedCells();
        
        foreach ($ships as $ship) {

            // J'initialise un tableau vide des points visités avec les points des cellules déjà occupés
            $arrayCellsVisited = $arrayOccupiedCells;

            // Tant que tout les points libres ne sont pas visités 
            $arrayShipPositions = [];
            while(count($arrayCellsVisited) !== ($this->size[0]*$this->size[1])) {

                $randomAvailableCellCoordinates = $this->findRandomAvailableCellCoordinates($ship, $arrayCellsVisited);

                $arrayShipPositions = $this->tryPlaceShipFromPoint($ship, $randomAvailableCellCoordinates, $arrayCellsVisited);
                
                if ($ship->size === count($arrayShipPositions)) {
                    break;
                }

            }

            if ($ship->size !== count($arrayShipPositions)) {
                throw new \Exception(`Impossible de placer le bateau {$ship->name}`);
            }

            foreach ($arrayShipPositions as $coordinates) {

                $this->setBoard($coordinates, $ship->identifiant);
                
            }
            
            $arrayOccupiedCells = [...$arrayOccupiedCells, ...$arrayShipPositions];

            $ship->coordinates = $arrayShipPositions;
            

        }
            
    }

    /**
     * Retourne les coordonnées d'une cellule libre prise au hasard et non visité
     *
     * @param Ship $ship
     * @param array $arrayCellsVisited
     * @return array
     */
    public function findRandomAvailableCellCoordinates(Ship $ship, array &$arrayCellsVisited): array {

        $result = [];

        [$numberMaxRowInBoard, $numberMaxColInBoard] = $this->size;

        // Je cherche un point compris entre 0 taille du board - 1 
        // et qui n'est pas dans les points déjà visités ou occupés
        do {
            $result = [rand(0, $numberMaxRowInBoard - 1), rand(0, $numberMaxColInBoard - 1)];
        } while(in_array($result, $arrayCellsVisited));

        $arrayCellsVisited[] = $result;

        return $result;

    }

    /**
     * Parcours le board pour retourner le tableau des coordonées des cases occupées
     *
     * @return array Tableau des coordonées des cases occupées
     */
    public function getOccupiedCells(): array {

        $result = [];

        $valueEmptyCell = Constants::getValueEmptyCell();

        foreach ($this->board as $keyRow => $columns) {

            $countValueInRow = array_count_values($columns);

            if ($countValueInRow[$valueEmptyCell] === $this->size[1]) {
                continue;
            }

            foreach ($columns as $keyColumn => $value) {
                
                if ($value === $valueEmptyCell) {
                    continue;
                }

                $result[] = [$keyRow, $keyColumn];

            }

        }

        return $result;
    }

    /**
     * Placement d'un bateau à partir d'un point libre. 
     * Test dans les 2 orientations et dans les 2 directions à chaque fois.
     *
     * @param Ship $ship
     * @param array $coordinatesOfReferenceCell
     * @param array $arrayCellsVisited
     * @return array Tableau vide si pas possible de placer le bateau, sinon tableau des coordonées de la position du bateau
     */
    public function tryPlaceShipFromPoint(Ship $ship, array $coordinatesOfReferenceCell, array &$arrayCellsVisited): array {

        $result = [];
        
        [$horizontalOrientation, $verticalOrientation] = [Constants::getHorizontalOrientationShip(), Constants::getVerticalOrientationShip()];

        // TODO passer les valeurs des directions en constant
        $directionsByOrientation = [$horizontalOrientation => ['up', 'down'], $verticalOrientation => ['left', 'right']];

        foreach ([$horizontalOrientation, $verticalOrientation] as $orientation) {
            
            foreach ($directionsByOrientation[$orientation] as $direction) {

                for ($i=0; $i < $ship->size; $i++) { 

                    switch ($direction) {

                        case 'up':
                            $currentCellCoordinates = [$coordinatesOfReferenceCell[0] - $i, $coordinatesOfReferenceCell[1]];
                            break;

                        case 'down':
                            $currentCellCoordinates = [$coordinatesOfReferenceCell[0] + $i, $coordinatesOfReferenceCell[1]];
                            break;

                        case 'left':
                            $currentCellCoordinates = [$coordinatesOfReferenceCell[0], $coordinatesOfReferenceCell[1] - $i];
                            break;

                        case 'right':
                            $currentCellCoordinates = [$coordinatesOfReferenceCell[0], $coordinatesOfReferenceCell[1] + $i];
                            break;
                        
                        default:
                            $currentCellCoordinates = $coordinatesOfReferenceCell;
                            break;

                    }

                    // TODO J'ajoute ce point au tableau des points visités (à passer en référence) EST-CE VRAIMENT NECESSAIRE
                    if (!$this->isInTheBoard($currentCellCoordinates)) {
                        continue;
                    }

                    if (!$this->isAvailableCell($currentCellCoordinates)) {
                        continue;
                    }

                    $result[] = $currentCellCoordinates;

                }

                // Si le bateau passe en entier dans cette direction, on s'arrête là
                if (count($result) === $ship->size) {
                    return $result;
                }

                // Sinon on vide les potentiels points enregistrés, et on passe à la direction suivante
                $result = [];

            }

        }

        return $result;

    }

    /**
     * Test si une case est libre ou non
     *
     * @param array $coordinates Coordinates table
     * @return boolean Is available or not
     */
    public function isAvailableCell(array $coordinates): bool {

        [$rowNumber, $colNumber] = $coordinates;

        return $this->board[$rowNumber][$colNumber] === Constants::getValueEmptyCell();

    }

    /**
     * Test if coordinates is in the board
     *
     * @param array $coordinates
     * @return boolean
     */
    private function isInTheBoard(array $coordinates) {
        
        [$numberMaxRow, $numberMaxCol] = $this->size;

        [$numberRow, $numberCol] = $coordinates;

        if ($numberRow < 0 || $numberRow >= $numberMaxRow) {
            return false;
        }

        if ($numberCol < 0 || $numberCol >= $numberMaxCol) {
            return false;
        }

        return true;

    }

}