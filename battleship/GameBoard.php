<?php

namespace Battleship;

require "vendor/autoload.php";

class GameBoard {

    private array $size;
    private array $board;
    private array $ships;

    function __construct(array $size, mixed $value)
    {
        $this->size = $size;
        [$maxX, $maxY] = $size;
        $this->board = array_fill(0, $maxY, array_fill(0, $maxX, $value));
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
     * @param string $value New value for cell
     * @return void
     */
    public function setBoard(array $coordinates, string $value) {
        [$x, $y] = $coordinates;
        $this->board[$y][$x] = $value;
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

        $this->ships = $ships;

        foreach ($this->ships as $keyShip => $ship) {
            $this->placeOneShipOnBoard($ship);
        }

    }



    /**
     * Place one boat on game board
     *
     * @param \Battleship\Ship $ship Ship to place
     * @return void
     */
    private function placeOneShipOnBoard(\Battleship\Ship $ship) {

        // Récupère la taille du board
        [$sizeX, $sizeY] = $this->size;

        // Tableau des directions
        $arrayPotentialsDirections = [\Battleship\Constants::getVerticalOrientationShip(), \Battleship\Constants::getHorizontalOrientationShip()];

        // Random direction
        $direction = $arrayPotentialsDirections[rand(0, 1)];

        // On cherche un point de départ aléatoire dans le board
        if ($direction == \Battleship\Constants::getVerticalOrientationShip()) {

            $referenceSize = $sizeY;
            $randomCoordinates = [rand(0, $sizeX - 1), rand(0, ($referenceSize - $ship->size) - 1)];

        } else {

            $referenceSize = $sizeX;
            $randomCoordinates = [rand(0, ($referenceSize - $ship->size) - 1), rand(0, $sizeY - 1)];

        }

        // On test si tout le bateau passe
        // Cell est dispo si toutes les cases de la taille du bateau sont libre et dans le board 
        for ($i=0; $i < $ship->size; $i++) {

            // On calcul les nouvelles coordonnées en fonction de la direction
            $currentCoordinates = $direction == \Battleship\Constants::getVerticalOrientationShip() ? [$randomCoordinates[0], $randomCoordinates[1] + $i]  : [$randomCoordinates[0] + $i, $randomCoordinates[1]]; 
            
            // Si la cellule courante n'est pas dispo, on recommence à zéro
            if (!$this->isAvailableCell($currentCoordinates)) {
                $this->placeOneShipOnBoard($ship);
            }

            // Si la cellule n'est pas dans le board, on recommence à zéro
            if (!$this->isInTheBoard($currentCoordinates)) {
                $this->placeOneShipOnBoard($ship);
            }

            // Sinon on place le bateau
            $this->setBoard($currentCoordinates, $ship->name);

        }


    }

    /**
     * Test if cell is available for place a ship.
     *
     * @param array $coordinates Coordinates table
     * @return boolean Is available or not
     */
    public function isAvailableCell(array $coordinates) {

        [$x, $y] = $coordinates;

        return !in_array($this->board[$y][$x], array_keys($this->ships));

    }

    /**
     * Test if coordinates is in the board
     *
     * @param array $coordinates
     * @return boolean
     */
    private function isInTheBoard(array $coordinates) {
        return true;
    }

}