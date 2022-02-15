<?php
include '/home/aswill/Desktop/mysqlq.php';
include '/home/aswill/Desktop/modWindow.php';

/*

 */
class Tree {
 
    private $_db = null;
    private $_branch_arr = array();
 
    public function __construct($myPDO) {
        //Подключаемся к базе данных, и записываем подключение в переменную _db
        $this->_db = $myPDO;
        //В переменную $_branch_arr записываем все категории (см. ниже)
        $this->_branch_arr = $this->_getBranch();
    }
 
    /**
     * Метод читает из таблицы branch все сточки, и 
     * возвращает двумерный массив, в котором первый ключ - id - родителя 
     * категории (parent_id)
     * @return Array 
     */
    private function _getBranch() {
        $query = $this->_db->prepare("SELECT * FROM `branch`"); //Готовим запрос
        $query->execute(); //Выполняем запрос
        //Читаем все строчки и записываем в переменную $result
        $result = $query->fetchAll(PDO::FETCH_OBJ);
        //делаем из одномерного массива - двумерный, в котором первый ключ - parent_id)
        $return = array();
        foreach ($result as $value) { //Обходим массив
            $return[$value->parent_id][] = $value;
        }
        return $return;
    }
 
    /**
     * Вывод дерева
     * @param Integer $parent_id - id-родителя
     * @param Integer $level - уровень вложености
     */
    public function outTree($parent_id, $level) {
        if (isset($this->_branch_arr[$parent_id])) { //Если категория с таким parent_id существует
            foreach ($this->_branch_arr[$parent_id] as $value) { //Обходим ее
                /**
                 * Выводим категорию 
                 *  $level * 25 - отступ, $level - хранит текущий уровень вложености (0,1,2..)
                 */
                echo "<div style='margin-left:" . ($level * 25) . "px;'>" . $value->name . " <button value=\"-" . $value->id .  "\" onclick=\"window.location.href='#openModal'\"> - </button> <button value=\"+" . $value->id .  "\"> + </button></div>";
                $level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->outTree($value->id, $level);
                $level--; //Уменьшаем уровень вложености
            }
        }
    }
 
}

/* 
$tree = new TreeOX2();
$tree->outTree(0, 0); //Выводим дерево
*/ 
?>
