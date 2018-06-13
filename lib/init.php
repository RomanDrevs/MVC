<?php
/**
 * Для того чтобы использовать десятки классов, ф-й и констант, обьявленых в разных файлах по всему проекту
 * будем использовать стандартную ф-ю __autoload
 */

require_once (ROOT.DS.'config'.DS.'config.php');

function __autoload($classname){
    $lib_path = ROOT.DS.'lib'.DS.strtolower($classname).'.class.php';
    $controllers_path = ROOT.DS.'controllers'.DS.str_replace('controller','',strtolower($classname)).'.controller.php';
    $models_path = ROOT.DS.'models'.DS.strtolower($classname).'.php';

    if (file_exists($lib_path)){
        require_once ($lib_path);
    }elseif (file_exists($controllers_path)){
        require_once ($controllers_path);
    }elseif (file_exists($models_path)){
        require_once ($models_path);
    }else{
        throw new Exception('Failed to include class:'.$classname);
    }
}
// Глобальная ф-я "__" - В любом месте проекта получаем перевод строки
function __($key, $default_value= ''){
    return Lang::get($key,$default_value);
}














//$myAutoload = function ($className)
//{
//    $path = __DIR__.'/../lib_test/'.sprintf('%s.php', ucfirst(str_replace('_', '/', $className)));
//    if (file_exists($path)) {
//        require_once $path;
//    }
//};
//
//spl_autoload_register($myAutoload);
////spl_autoload_call ($myAutoload);