<?php

use Battleship\Strategy\IStrategy;

/**
 * Stratégie de cible après un tir réussi
 */
class TargetStrategy implements IStrategy
{

    public function shoot(): string
    {
        return 'A1';
    }

}
