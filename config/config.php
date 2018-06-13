<?php
/**
 * Основной configuration file приложения
 * Хранит различные параметры. Например: название сайта или параметры подключения к DB
 * Для того чтобы в config.php файле был доступен обьявленный в другом файле класс Config нам необходимо включить файл
 * config.class.php
 */

// вызовем статический метод set() класса Config, key='site_name',value='Your Site Name'
Config::set('site_name', 'DREVS');

// определение списка языков, которые используются в проекте
Config::set('languages', array('en', 'fr'));

/** Все необходимые настройки для работы класса Router будут добавлятся в файле config.php
 * Добавляем роуты (Routes). Rout name => method prefix . Настройки по умолчанию */
Config::set('routes', array(
    'default' => '', // key - название роута, а value -префикс метода
    'admin' => 'admin_',
));
/** 1) Добавляем setting - default_route и её value будет default. Если в url отсутствует обращение к админ панели,
 * то будет использ. default_route ;2) Затем задаём язык по умолчанию;3) Дальше Задаём название контроллера по умолчанию
 * 4) Далее название метода контоллера(action) by default. http:localhost/pages -> будет вызван index котроллера pages*/
Config::set('default route', 'default');
Config::set('default_language','en');
Config::set('default_controller','pages');
Config::set('default_action','index');

// Для Подключения к базе данных необходимы такие параметры host, login, password, name of DB
Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password','');
Config::set('db.db_name','mvc');


/**Настройка 'salt' - специальная строка которая содержит случайный(random) набор символов. Используется при генерации
 * хеша пароля - salt добавляется в исходные строки, которые нужно захешировать. Усложняем возможный подбор
 * пользовательского password-a*/

Config::set('salt', 'jd7sj3sdkd964he7e');
