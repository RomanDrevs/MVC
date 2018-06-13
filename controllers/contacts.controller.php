<?php
class ContactsController extends Controller{
    // В конструкторе - $this->model- задаём атрибут(свойство) model с помощью обьекта класса Message(создаем обьект)
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Message();
    }
    /**
     * Метод index() отвечает за отображение и обработку формы обратной связи(contact form)ю
     * Условие(if())- если получаем POST запрос то вызываем метод save() текущей модели
     */
    public function index(){
        if($_POST){
            if($this->model->save($_POST)){
                Session::setFlash('Thank You! Your message was sent successfully');
            }
        }
    }
    /**
     * Метод admin_index() выводит список сообщений отправленных посетителями сайта.
     * В массив $data записуется полученый список сообщений*/
    public function admin_index(){
        $this->data = $this->model->getList();
    }

}