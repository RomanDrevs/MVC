<?php
/**
 * Save settings of MVC application - connection settings with DataBase.
 * Метод get()-для того чтобы получать значение хранимое в настройках. Метод set()-чтобы задать(засетить) саму настройку
 */
class Config{
    protected static $settings = array(); // settings af key => value

    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }
    public static function set($key,$value){
        self::$settings[$key] = $value;

    }

}