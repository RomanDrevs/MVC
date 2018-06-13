<?php
/**
 * Диспетчер запросов or router - отв. за парсинг запросов к нашему приложению, его задача разобрать URI и получить из
 * него контроллер, метод и др.части;
 * После парсинга url, который будет выполнять обьект Router-a, в них будет записаны соответ. значения роута,
 * префикса методов контроллера и текущего языка сайта
 * В папке lib хранится код основных классов приложения
 */

class Router{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $method_prefix;
    protected $language;

    /**
     * @return mixed
     * Чтобы получать доступ к аттрибутам далее в приложении создаются геттеры для каждого аттрибута(свойства)
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /** Для того чтобы использовать данный класс нужно создать конструктор;
     * Конструктор принимает аргумент $uri тоисть строку запроса;
     * Также в нём происходит разбор URI и получение конроллера,метода и других параметров
     * Конструктор будет получать из запроса route, language, controller, method(action) и other parameters
     * Также очищаем значение uri от "/" with function trim(), а затем обработать строку с помощью ф-и urldecode() -
     * чтобы правильно обрабатывать закодированные символы из url
     */
    public function __construct($uri){

        $this->uri = urldecode(trim($uri, '/'));

        //Get Defaults (Получаем настройки по умолчанию)
        $routes = Config::get('routes');
        $this->route = Config::get('default route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->language = Config::get('default_language');
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');

        /**Разбор uri.
         * Разделим uri с помощью ф-и explode, избавляемся от знака "?" и GET param(если они в строке запроса);
         * $uri_parts - cтрока для парсинга из которой мы будем получать route,language,controller,action and other params
         * Задано условие(if) которое буде проверять массив $path_parts на не пустоту:
         * Код проходит поочередно все элементы массива и разбирает его по составляющим
         * array_shift($path_parts) - сдвинул первый елемент из массива
         */
        $uri_parts = explode('?',$this->uri);
        $path = $uri_parts[0]; // Get path like /lng/controller/action/param1/param2/.../...
        $path_parts = explode('/',$path);

        if(count($path_parts)){
            // Get route or language at first element
            if(in_array(strtolower(current($path_parts)),array_keys($routes))){
                $this->route = strtolower(current($path_parts)); //  хранится актуальное значение роута - admin or default
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            } elseif (in_array(strtolower(current($path_parts)),Config::get('languages'))){
                $this->language = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            /** Get controller - next element of array */
            if (current($path_parts)){
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            /** Get action - next element after controller */
            if (current($path_parts)){
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            /** Все елементы которые всё ещё остаюься в массиве path_parts это параметры - param1 & param2
             Get params - all the rest. Таким образом задаём атрибуты в обьекте Router-a */
            $this->params = $path_parts;
        }
    }
    /**
     * Ф-я перенаправления - redirect.
     * Аргумент ф-и - адрес для редиректа. Ф-я посылает Header with specified location
     */
    public static function redirect($location){
        header("Location:$location");
    }
}
