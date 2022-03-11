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

    //DBへ情報を登録するメソッド（insert)
    public function add($arr){
        $sql = "INSERT INTO users(user_name, email, password, roll, created) VALUES(:user_name, :email, :password, :role, :created)";
        
        $stmt = $this->connect->prepare($sql);
        $params = array(
            ':user_name'=>$arr['user_name'], 
            ':email'=>$arr['email'], 
            ':password'=>$arr['password'], 
            ':role'=>0, 
            ':created'=>date('Y-m-d H:i:s')
        );
        $stmt->execute($params);
    }

    //DBへ情報を登録するメソッド（insert)
    public function registerProduct($arr){
        $sql = "INSERT INTO users_products(user_id, product_id, num, created) VALUES(:user_id, :product_id, :num, :created)";
        
        $stmt = $this->connect->prepare($sql);
        $params = array(
            ':user_id'=>$arr['user_id'],
            ':product_id'=>$arr['product_id'],
            ':num'=>$arr['num'],
            ':created'=>date('Y-m-d H:i:s')
        );
        $stmt->execute($params);
    }
}
?>