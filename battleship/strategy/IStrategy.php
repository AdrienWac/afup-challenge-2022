<?php 

namespace Battleship\Strategy;

use Battleship\ProbabilityBoard;

require "vendor/autoload.php";

interface IStrategy {

    public function shoot(): string;

    public function generateBoard(): ProbabilityBoard;

    public function extractCoordinatesCellWithHighestProbability(ProbabilityBoard $board): array;

}