<?php
/**
 * Один из важнейших классов в приложении. Добавляем код который позволит  выводить пользователям сайта flash messages
 * (информационные сообщения). Для того чтобы создать сообщение нам необходим setter
 */
class Session
{
    // свойство содержит текст передаваемого сообщения
    protected static $flash_message;

    /** Аргумент ф-и - текст сообщения; Обычно ф-я вызывается в контроллерах
     * В теле ф-и - присвоение значения аргумента свойству $flash_message */
    public static function setFlash($message){
        self::$flash_message = $message; //
    }

    /** Проверяем наличие послания для пользователя = проверка свойства $flash_message. Ф-я будет вызыватся в шаблонах
     * роута как шаблон phtml*/
    public static function hasFlash()
    {
        return !is_null(self::$flash_message);
    }

    /** Задача ф-и - Вывести текущие сообщения с помощью echo и сразу после этого echo очистить.Тоисть все передаваемые
     * сообщения будут показаны user-y только однин раз*/
    public static function flash()
    {
        echo self::$flash_message;
        self::$flash_message = null;
    }

    /** Метод предназначен для записи данных в массив $_SESSION по ключу. Всё что делает метод - записывает
     * $value в суперглобальный массив $_SESSION */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /** Ф-я получает значение из сессии. Используется например - для получения логина авторизованого user-a */
    public static function get($key){
        if (isset($_SESSION[$key])) { // если ключ задан и определен, будет возвращено определённое значение
            return $_SESSION[$key];
        }
        return null;
    }

    /** Метод отвечает за удаление $key и $value из сессии. Метод вызывает ф-ю unset для указаного $key суперглобального
     * массива $_SESSION(unset() вызывается только если $key существует)*/
    public static function delete($key){
        if (isset($_SESSION[$key])) { // если ключ задан и определен, то ключ($key) $_SESSION удаляется
            unset ($_SESSION[$key]);
        }
    }
    /** Задача метода - уничтожать сессию. Этот метод будет вызыватся при выходе user-a из системы */
    public static function destroy(){
        session_destroy();
    }

}