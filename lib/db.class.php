<?php
/**
 * Класс отвечает за соединение с базой данных. Главная задача класса DB - выполнять запросы к db и возвр. их результаты
 */
class DB{
    protected $connection;

    /**
     * Метод создаёт обьект подключения. Задача конструктора - создать новое подключение с помощью класса
     * mysqli - Улучшенный модуль MySQL
     */
    public function __construct($host,$user,$password,$db_name){
        $this->connection = new mysqli($host,$user,$password,$db_name);
        if(mysqli_connect_error()){ // check on errors
            throw new Exception('Could not connect to DB');
        }
    }
    /**
     * Ф-я query выполняет запросы к db и возвращает результаты; $sql-строка запроса; $result = значение возвращаемое
     * ф-ей query обьекта connection. Существуют проверки, одна из них - проверка на тип полученого значения с помощью
     * ф-и is_bool() для того чтобы ф-я query возвращала правильн. результат независимо от типа SQL запроса
     */
    public function query($sql){

        if (!$this->connection){ // проверка на существование подключения
            return false;
        }
        $result= $this->connection->query($sql);
        if (mysqli_error($this->connection)){ // if во время выполнения запроса возникает error - бросаем исключение
            throw new Exception(mysqli_error($this->connection));
        }
        if(is_bool($result)){
            return $result;
        }
        /** Вероятные данные полученные с помощью ф-и fetch_assoc. Цикл добавляет все полученые строки в массив $data*/
        $data = [];
        while ($row = mysqli_fetch_assoc($result)){ //
            $data[] = $row;
        }
        return $data;
    }
    /**
     * Предотвращаем sql injections. Ф-я escape обрабатывает строки с помощью ф-и mysqli_escape_string До того как они
     * будут попадать в SQL запрос
     */
    public function escape($str){ //
        return mysqli_escape_string($this->connection,$str);

    }
}