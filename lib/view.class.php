<?php
/**
 * Класс будет отвечать за работу с представлениями(views)
 * Обьекты класса View будут создаватся во всех случаях когда необходимо использовать views,
 * тоисть при необходимости передавать в них данные и получать HTML код . $data - для хранения данных которые перед. от
 * контроллера во view (связущее звено:контроллер><шаблон); $path - содержыт путь к текущему файлу представления(view)
 */
class View{
    protected $data;
    protected $path;

    /**
     * Определить путь к шаблону = route + name of controller + name of action. Почему метод static? - определяет путь
     * к шаблону без создания обьета.
     * $controller_dir - название контроллера; $template_name - название HTML шаблона (такое же как и название метода
     * контроллера, и начинается с префикса метода)
     */
    protected static function getDefaultViewPath(){
        $router = App::getRouter();
        if (!$router){
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction(). '.phtml';

        return  VIEWS_PATH.DS.$controller_dir.DS.$template_name; // Полный путь к шаблону
    }

    public function __construct($data = [],$path = null){ // конструктор выпол. действия по инициализации обьекта
        if (!$path){
            $path = self::getDefaultViewPath();
        }
        if(!file_exists($path)){
            throw new Exception('Template file is not found in path:'.$path);
        }
        $this->path=$path;
        $this->data=$data;
    }
    /**
     * Метод отвеч. за рендеринг шаблона и возвращает готовый HTML код, ф-я не нуждается в атрибутах,использует атрибуты
     * обьекта. Буферизация вывода - нужна чтобы включить файл шаблона, и получить готовый HTML код в буфере;
     * include ($this->path) - включаем  текущий путь к шаблону в буферизацию вывода;
     *  вызываем ф-ю $content = ob_get_clean() - чтобы получить готовый HTML код view
     */
    public function render(){
        $data=$this->data;
        ob_start();
        include ($this->path);
        $content = ob_get_clean();
        return $content;
    }

}