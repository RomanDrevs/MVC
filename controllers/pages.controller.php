<?php
/**
 * Класс отвечает за отображение простых страниц сайта;
 * Improve class PagesController - добавил код, который будет использовать модель Page для получения данных;
 * Конструктор: 1)parent::__construct($data) - вызов конструктора родительского класса;
 * 2)Создал екземпляр класса Page - получили доступ к обьекту модели с помощью $model.
 * Метод index() - выводит список страниц, по ключу 'pages' с помощью ф-и getList нашей модели(строка будет доступна и
 * во view(шаблоне))
 */
class PagesController extends Controller {

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index(){
        $this->data['pages'] = $this->model->getList();
    }
    /**
     * Получаем алиас(параметр запроса) требуемой страницы с помощью метода getParams нашего роутера. Есть проверка(if)
     * с помощью ф-и isset() задан ли первый параметр или нет, если да - алиасом будет его значение в нижнем регистре
     */
    public function view(){
        $params = App::getRouter()->getParams();
        if (isset($params[0])){
            $alias = strtolower($params[0]);
            $this->data['page'] = $this->model->getByAlias($alias);
        }

    }
    /**
     * Чтобы вывести список страниц в шаблоне их нужно получить в методе контроллера.Получаем список с помощью ф-и
     * getList модели Page. список страниц помещается сразу в массив $data
     */
    public function admin_index(){
        $this->data['pages'] = $this->model->getList();
    }
    /**
     * Задача метода - добавление new page. Если был получен POST запрос, то вызываем метод save() и получаем messages
     * ($result - вызов метода save() модели Page - аргумент post запрос);
     */
    public function admin_add(){
        if ($_POST){
            $result = $this->model->save($_POST);
            if($result){
                Session::setFlash('Page was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect("/admin/pages/");
        }
    }
    /**
     * Задача метода - отобразить форму редактирования страницы с заполнеными полями ввода.
     * Учитываем $id of page которая была отредактирована; $result - вызов save() модели Page - аргумент post запрос
     * & id of edited page;
     */
    public function admin_edit(){
        if ($_POST){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result){
                Session::setFlash('Page was saved.');
            }else{
                Session::setFlash('Error.');
            }
            Router::redirect("/admin/pages/");
        }
        /**
         * проверка что id страницы задан в параметрах запроса(если задан-то в массив $data with key 'page' запишем
         * результат ф-и getById. Аргумент ф-и getById - переданный параметр(номер страницы). Если params не задан
         * - собщение "Wrong..." и redirect-им user-a обратно на список страниц.
         * Router::redirect() - вызов метода redirect класса Router */
        if(isset($this->params[0])){
            $this->data['page'] = $this->model->getById($this->params[0]);
        }else{
            Session::setFlash('Wrong page id.');
            Router::redirect("/admin/pages/"); //
        }
    }

    /**
     * Метод отвечает за удаление pages. Метод обращается к модели Page. В методе условие(if) которое проверяет что id
     * страницы задан. Если id задан, то выполняется вызов метода delete модели Page
     */
    public function admin_delete(){
        if(isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if($result){
                Session::setFlash('Page was deleted.');
            }else{
                Session::setFlash('Error.');
            }
        }
        Router::redirect("/admin/pages/");
    }
}