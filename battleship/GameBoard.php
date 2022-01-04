<?php

namespace Battleship;

require "vendor/autoload.php";

class GameBoard {

    private array $board;
    private array $ships;

    function __construct(array $size, mixed $value)
    {
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

        $arrayPotentialsDirections = [\Battleship\Constants::getVerticalOrientationShip(), \Battleship\Constants::getHorizontalOrientationShip()];

        $randomDirection = $arrayPotentialsDirections[rand(0, 1)];




    }

    /**
     * Get random cell in board whos is available
     *
     * @param array $arrayCellCoordinatesAlreadyUsed
     * @param string $direction
     * @return void
     */
    private function getRandomAvailableCell(array $arrayCellCoordinatesAlreadyUsed, string $direction) {
        
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

}