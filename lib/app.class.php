<?php
/**
 * Класс App(application) - Отвечает за обработку запросов и вызывает методы контроллеров;
 * В коде класса App выполняется подключение к базе данных;
 * Свойство $router - для работы с обьектом Router-a, сделали static так как нам необходим только один Router;
 * $db - с помощью этого свойста получаем доступ к обьекту класса DB из любого места проекта
 * Метод getRouter() - использ. для получения обьекта Router-a, вызвав метод getRouter класса App
 */
class App{
    protected static $router;

    public static $db;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }
    /**
     * Метод run() отвечает за обработку запросов к приложению; $uri будет использ. для создания обьекта Router-a
     * Далее создаётся обьект класса DB и передаем в качестве аргумента настройки подключения к db с config.php
     */
    public static function run($uri){

        self::$router = new Router($uri);

        self::$db = new DB(Config::get('db.host'),Config::get('db.user'),Config::get('db.password'),Config::get('db.db_name'));

        /** Loading of language file должна выполнятся как только требуемый language определён;
        Языковые настройки загружаются автоматически, сразу после создания обьекта Router-a */
        Lang::load(self::$router->getLanguage());

        /**
         * class App создаёт необходимый обьект контроллера и вызывает нужный метод(главная задача)
         * $controller_class - Получаем название класса контролера ;
         * $controller_method - Требуемое значение = префикс+название метода контроллера
         * $layout - название роутера (определение роута)
         */
        $controller_class = ucfirst(self::$router->getController()).'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());
        $layout = self::$router->getRoute();
        /**
         * Проверяем выполнил ли user вход или нет. При каждом запросе к роуту 'admin' нужно проверять - имеет ли user
         * на это право.Условие(if) - если запрошена одна из страниц admin panel-и,но значение поля 'role' текущей session
         * не равно admin, то делаем редирект пользователя на форму логина(означает что все not authorized users будут
         * попадать на форму логина,где им будет предложено войти в систему). Также исключаем из проверки - страницу
         * login-a(чтобы не получить бесконечного зацикливания)
         */
        if( $layout == 'admin' && Session::get('role') != 'admin' ){
            if ($controller_method != 'admin_login'){
                Router::redirect('/admin/users/login');
            }
        }
        /**
         * Имеем название класса контроллера и его метод;Далее создаём обьект контроллера и вызываем метод по имени обьекта;
         * Calling controller's method
         * Controller's action may return a view path;
         * Есть Проверка(if) на существование метода - method_exists. $view_path - путь к шаблону = значение метода;
         * Добавили код который будет осуществлять рендеринг views - получаем данные от controller и передаем во view.
         * Если значение методом контроллера не возвращается, путь к шаблону определён самим обьектом view(представление)
         * Вызываем ф-ю render обьекта View и записываем результат в переменную content
         */

        $controller_object = new $controller_class();
        if (method_exists($controller_object, $controller_method)){
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(),$view_path);
            $content = $view_object->render();     //  ключ 'content' массива $data в default.phtml шаблоне(layout)
        } else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.' does not exists ');
        }
        /**
         * Rendering шаблона
         * $layout_path - путь к основному шаблону
         * Обьект класса View: аргументы - 1)массив(key='content',value='content') и 2)путь к layout(шаблону)
         */
        $layout_path =VIEWS_PATH.DS.$layout.'.phtml';
        $layout_view_object = new View(compact('content'),$layout_path);
        echo $layout_view_object->render();
    }
    }