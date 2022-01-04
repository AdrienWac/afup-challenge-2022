<?php 
namespace Battleship;

require "vendor/autoload.php";



class Constants {
    
    const STATE_ALIVE_SHIP = 'alive';

    const HORIZONTAL_ORENTATION_SHIP = 'horizontal';
    const VERTICAL_ORENTATION_SHIP = 'vertical';
    

    public static function getStateAliveShip() {
        return self::STATE_ALIVE_SHIP;
    }

    public static function getHorizontalOrientationShip() {
        return self::HORIZONTAL_ORENTATION_SHIP;
    }

    public static function getVerticalOrientationShip() {
        return self::VERTICAL_ORENTATION_SHIP;
    }

}
