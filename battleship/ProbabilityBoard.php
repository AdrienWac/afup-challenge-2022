<?php

namespace Battleship;

require "vendor/autoload.php";

use Battleship\Constants;
use Battleship\GameBoard;

class ProbabilityBoard extends GameBoard{

    private array $ships;
    private array $arrayVisitedCoordinates;


    function __construct(array $size)
    {   
        parent::__construct($size);
    }

    /**
     * Calcul les probabilités qu'une case du board puisse accueillir un bateau
     *
     * @return void
     */
    public function calculateProbabilities(): void
    {

    }

}