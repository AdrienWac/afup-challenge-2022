<?php 

namespace Battleship\Strategy;

use Battleship\ProbabilityBoard;

require "vendor/autoload.php";

interface IStrategy {

    public function shoot(): array;

    public function generateBoard(): ProbabilityBoard;

    public function getCurrentOrientation(): ?string;

    public function getCurrentDirection(): ?string;

}