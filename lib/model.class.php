<?php
/**
 * Базовый класс моделей; $db - доступ к обьекту класса DB; в __construct()  - задаём значение свойства $db.
 */
class Model{
    protected $db;

    public function __construct(){
        $this->db = App::$db;
    }
}