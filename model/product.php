<?php
require_once("DB.php");

class Product extends DB{

    

    //参照のメソッド
    public function findAll(){
        $sql = 'SELECT * FROM products';
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    //参照（条件付き）
    public function findById($id){
        $sql = 'SELECT * FROM products WHERE id = :id';
        $stmt = $this->connect->prepare($sql);
        $params = array(':id'=>$id);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result;
    }

    
}
?>