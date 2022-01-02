<?php
namespace Battleship;

use PHPUnit\Framework\TestCase;
use Battleship\Main;

class MainTest extends TestCase {

    public function testShoot() {
        $mainTest = new Main();
        $this->assertSame('shoot', $mainTest->shoot());
    }

}