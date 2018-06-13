<?php
/**
 * Модель User работает с таблицой 'users' базы 'mvc'. Метод getByLogin c аттрибутом $login - нужен для того чтобы
 * выполнять аунтентификацию по login-у и password-у(нам необходимо получить запись из db по полю 'login')
 * $login - обработанное значение ф-ей escape класса DB; $sql - запрос к таблице 'users';
 * Условие(if) - если в массиве $result есть елемент возвращаем его, в противном случае метод возвратит false.
 */
class User extends Model {

    public function getByLogin($login){
        $login = $this->db->escape($login); //
        $sql = "select * from users where login = '{$login}' limit 1"; //
        $result = $this->db->query($sql); // result of query
        if(isset($result[0])){
            return $result[0];
        }
        return false;
    }
}