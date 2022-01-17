<?php 
namespace Battleship;

require "vendor/autoload.php";



class Constants {
    
    const STATE_ALIVE_SHIP = 'alive';
    const STATE_SUNK_SHIP = 'sunk';

    const HORIZONTAL_ORENTATION_SHIP = 'horizontal';
    const VERTICAL_ORENTATION_SHIP = 'vertical';

    const LEFT_DIRECTION = 'left';
    const RIGHT_DIRECTION = 'right';
    const UP_DIRECTION = 'up';
    const DOWN_DIRECTION = 'down';

    const VALUE_EMPTY_CELL = 0;
    

    public static function getStateAliveShip() {
        return self::STATE_ALIVE_SHIP;
    }

    public static function getStateSunkShip()
    {
        return self::STATE_SUNK_SHIP;
    }

    public static function getHorizontalOrientationShip() {
        return self::HORIZONTAL_ORENTATION_SHIP;
    }

    public static function getVerticalOrientationShip() {
        return self::VERTICAL_ORENTATION_SHIP;
    }

    public static function getValueEmptyCell() {
        return self::VALUE_EMPTY_CELL;
    }

    public static function getLeftDirection()
    {
        return self::LEFT_DIRECTION;
    }

    public static function getRightDirection()
    {
        return self::RIGHT_DIRECTION;
    }

    public static function getUpDirection()
    {
        return self::UP_DIRECTION;
    }

    public static function getDownDirection()
    {
        return self::DOWN_DIRECTION;
    }

}
