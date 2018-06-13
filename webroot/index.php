<?php
/**
 * Поскольку Файл index.php это точка входа в приложение, он должен включать файл инициализации init.php и передавать
 * запрос диспетчеру запросов тоисть обьекту класса Router;
 * session_start()- вызов ф-и. Тоисть работаем с сессиями, какая бы страница сайта на даный момент не была бы загружена;
 * Определение константы VIEWS_PATH - пути к файлам представления(views).
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH',ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'init.php');

//Session::setFlash('Test flash message'); //тест на вывод сообщения для пользователя
//$router = new Router($_SERVER['REQUEST_URI']);
//
//echo '<pre>';
////выводим в браузер результат парсинга запроса с помощью геттеров класса Router
//print_r('Route: '.$router->getRoute().PHP_EOL);
//print_r('Language: '.$router->getLanguage().PHP_EOL);
//print_r('Controller: '.$router->getController().PHP_EOL);
//print_r('Action to be called: '.$router->getMethodPrefix().$router->getAction().PHP_EOL);
//echo 'Params: ';
//print_r($router->getParams());
// Все исключения возникающие в приложении должны перехватыватся в этом файле
session_start();

App::run($_SERVER['REQUEST_URI']); // вызов метода run в единой точке входа

//пример класса DB будет доступен в коде приложения через свойство $db класса App
//$test = App::$db->query('select * from pages');
//echo "<pre>";
//print_r($test);