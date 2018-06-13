<?php
/**
 * Модель необходима чтобы все поля Contact Form сохранялись в базу данных.
 * Метод save() выполняет запросы к базе данных и добаляет или обновляет запись таблицы 'messages'.аргумент(свойство)
 * $data - данные формы; свойство $id - не обязательно,если оно незадано (null) значит надо добавить запись,если $id > 0,
 * то нужно обновить запись с указаным id;
 * В методе существует проверка - что обязательные элементы массива $data заданы. Если проверка прошла - то готовим
 * данные для записи в базу данных и избавляемся от возможных sql injections: переменной $name,$email,$message присвоим
 * значение ф-и escape класса DB. Проверим елементы каждого из массива $data
 */
class Message extends Model {

    public function save($data, $id = null){
        if ( !isset($data['name']) || !isset($data['email']) || !isset($data['messages']) ){
            return false;
        }
        $id = (int)$id;
        $name = $this->db->escape($data ['name']);
        $email = $this->db->escape($data ['email']);
        $message = $this->db->escape($data ['messages']);

        /**
         * if определяет вставить запись в таблицу или обновить существующую запись;
         * return - вернёт результат запроса к database
         */
        if(!$id){ //Query - Add new record
            $sql = "
                insert into messages
                  set name = '{$name}',
                      email = '{$email}',
                      messages = '{$message}'
            ";
        } else { //Query - Update existing record
            $sql = "
                update messages
                  set name = '{$name}',
                      email = '{$email}',
                      messages = '{$message}'
                  where id = {$id}
            ";
        }

        return $this->db->query($sql);
    }
    /** Метод для того чтобы получить список сообщений - это аналог метода getList модели Page.
     * Выборка из table messages - 1;return - вернёт результат запроса(испол. ф-ю query и строку запроса как аргумент)
     */
    public function getList(){
        $sql = "select * from messages where 1";
        return $this->db->query($sql);
    }
}