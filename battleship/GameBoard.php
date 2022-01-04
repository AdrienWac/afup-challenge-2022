<?php

namespace Battleship;

require "vendor/autoload.php";

class GameBoard {

    private array $board;

    function __construct(array $size, mixed $value)
    {
        [$maxX, $maxY] = $size;
        $this->board = array_fill(0, $maxY, array_fill(0, $maxX, $value));
    }


    public function getBoard() {
        return $this->board;
    }

    public function setBoard(array $coordinates, string $value) {
        [$x, $y] = $coordinates;
        $this->board[$y][$x] = $value;
    }

    public function draw()
    {

        $result = [];

        array_map(function ($array) use (&$result) {
            $result[] = implode('', $array);
        }, $this->board);

        print_r($result);

    } 

}