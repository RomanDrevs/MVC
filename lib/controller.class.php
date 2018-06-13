<?php
/**
 * Все контроллеры приложения должны наследоватся от одного базового класса.
 * $data - содержит всю информацию которая передаётся с controller-a во view; $model - для доступа к обьекту Model-и;
 * $params - хранятся params полученные из строки запроса;
 */
class Controller{
    protected $data;
    protected $model;
    protected $params;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

/** Конструктор в качестве аргумента $data будет принимать начальные данные;
 * Если конструктор будет вызыватся без дополнительных параметров, то $data будет содержать пустой массив
 */

    public function __construct($data = array()){
        $this->data = $data;
        $this->params = App::getRouter()->getParams(); // параметры запроса которые получаем с обьекта роутера
    }


}