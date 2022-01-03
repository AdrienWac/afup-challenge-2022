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

}