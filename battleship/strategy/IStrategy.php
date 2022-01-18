<?php 

namespace Battleship\Strategy;

use Battleship\ProbabilityBoard;

require "vendor/autoload.php";

interface IStrategy {

    public function __construct(array $size, array $ships, array $arrayCellsVisited);

    public function shoot(): string;

    public function generateBoard(): ProbabilityBoard;

}