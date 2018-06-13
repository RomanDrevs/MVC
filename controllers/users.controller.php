<?php
/** Контроллер отвечает за login и logout of users. Сам класс UsersController очень похож на другие контроллеры. Этот
 *класс взаимодействует с моделью User, поэтому создается соответствующий обьект класса User в конструкторе
 */
class UsersController extends Controller {

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new User();
    }
    /** Метод admin_login() выводит и обрабатывает форму login-a.
     * Условие(if) - если мы получаем POST запрос и если поля login и password будут переданы, то присваиваем $user -
     * результат вызова метода getByLogin модели User (в качестве аргумента указаный в форме login).
     * Также вычисляем md5 хеш переданого пароля чтобы сравнить со значен. из DB(хеш получаем с помощью salt).
     * Условие(вложеный if()) - чекаем что $user не пустая, пользователь является активным
     * (поле 'is_active' =1), и что полученый хеш совпадает с хешем из table 'users'. Если условие выполн. - login &
     * password правильные и user прошёл аутентификацию. Далее записываем login и role user-a в сессию.
     * Наличие логина в session-пользователь выполнил вход в систему. Далее user попадает в admin panel(вызов redirect)*/
    public function admin_login(){
        if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt') . $_POST['password']);

            if ($user && $user['is_active'] && $hash == $user['password']) {
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
            }
            Router::redirect('/admin/'); //вызов метода и передаём адрес редиректа
        }
    }
    /** Метод отвечает за возможность выхода из системы. Этот метод уничтожает сессию и выполняет редирект. Метод не
     * требует adding view(представления) admin_logout.phtml, так как он ничего не выводит */
    public function admin_logout(){
        Session::destroy();
        Router::redirect('/admin/');
    }

}