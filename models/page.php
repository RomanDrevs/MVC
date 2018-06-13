<?php
/**
 * Модель Page для работы с текстовыми страницами.
 * Ф-и getByAlias() & getList() будут возвращать результат выполнения запроса или null;
 * C помощью метода getList() получаем список страниц: 1)Выбираем из table pages is_published = 1,значит что страница
 * опубликована; 2) Условие(if) если true то к запросу добавляется соответ. условие; 3) return - возвращает результат
 * запроса (используем ф-ю query и строку запроса как аргумент).
 */
class Page extends Model {

    public function getList($only_published = false){
        $sql = "select * from pages where 1";
        if($only_published){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql); //
    }

    /**
     * Получаем данные одной страницы по её алиасу. Метод принимает в качестве аргумента требуемый alias;
     * Обрабатываем аргумент with function escape() - чтобы избежать sql injections
     */
    public function getByAlias($alias){
        $alias = $this->db->escape($alias); //
        $sql = "select *from pages where alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result [0] : null;
    }

    public function getById($id){ //для методов edit & delete. используется в методе pages.controller
        $id= (int)$id;
        $sql = "select *from pages where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result [0] : null;
    }
    /**
     * Метод save() отвечает за сохранение данных в базу данных.Метод решает две задачи- adding pages и editing of pages
     * Проверка прошла, готовим данные для записи в базу данных и избавляемся от возможных sql injections
     * Переменным присвоим значение ф-и escape() класса DB. Проверим елементы 'alias','title',... массива $data;
     * Условие(second if()) определяет вставить запись в таблицу или обновить существующую запись;
     * return - вернёт результат запроса к базе данных.
     */

    public function save($data, $id = null){
        if ( !isset($data['alias']) || !isset($data['title']) || !isset($data['content']) ){
            return false;
        }
        $id = (int)$id;
        $alias = $this->db->escape($data ['alias']);
        $title = $this->db->escape($data ['title']);
        $content = $this->db->escape($data ['content']);
        $is_published = isset($data ['is_published']) ? 1 : 0;

        if(!$id){ //Query - Add new record
            $sql = "
                insert into pages
                  set alias = '{$alias}',
                      title = '{$title}',
                      content = '{$content}',
                      is_published = '{$is_published}'
            ";
        }else{ //Query - Update existing record
            $sql = "
                update pages
                  set alias = '{$alias}',
                      title = '{$title}',
                      content = '{$content}',
                      is_published = '{$is_published}'
                  where id = {$id}
            ";
        }

        return $this->db->query($sql); //
    }


     // Метод отвечает за удаление данных с базы данных. return - возвращает рез-тат выполнения запроса
    public function delete($id){
        $id = (int)$id;
        $sql = "delete from pages where id = {$id}";
        return $this->db->query($sql); //
    }
}