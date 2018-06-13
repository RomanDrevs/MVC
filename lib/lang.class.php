<?php
/**
 * Класс Lang отвечает за работу с языковыми файлами en.php & fr.php
 * Позволяет загружать language's files и получать доступ к переводам на разных языках;
 * Метод (Ф-я) load загружает дынные из en.php & fr.php и записует язык. настройки в $data;
 * $lang_file_path - путь языкового файла. В методе -  проверка(if) на существование файла по этому path
 */
class Lang{
    protected static $data; // saves languages settings

    public static function load($lang_code){
        $lang_file_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';
        if (file_exists($lang_file_path)){
            self::$data = include($lang_file_path);
        } else {
            throw new Exception('Lang file not found: '.$lang_file_path);
        }
    }
    /** Метод get принимает key в качестве аргумента и возвращает значение of key для загруженого языка
    кроме key принимает второй аргумент- value которое будет возвращено если key не найдён*/
    public static function get($key, $default_value = ''){
        ////checking on presence of key and return appropriate value
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
    }
}
