<?php

use PHPUnit\Framework\TestCase;
use Battleship\Ship;
use Battleship\Constants;

class ShipTest extends TestCase {


    /**
     * Test d'un tir qui touche un bateau
     *
     * @return void
     */
    public function testBeShotShipHit() {
        
        $ship = new Ship('Test', 2, 1);

        $ship->coordinates = [ [0,0], [1,0] ];

        $ship->beShot([0,0]);

        $this->assertEqualsCanonicalizing([[1,0]], $ship->coordinates);

        return $ship;
    }

    /**
     * @depends testBeShotShipHit
     * Test d'un tir qui touche et coule le bateau
     *
     * @param Ship $ship Bateau du test précédent
     * 
     * @return void
     */
    public function testBeShotShipSunk(Ship $ship) {

        $ship->beShot([1,0]);

        $this->assertEquals(Constants::getStateSunkShip(), $ship->getState());

    }


}