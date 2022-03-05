<?php
require_once("DB.php");

class User extends DB{

    //参照のメソッド
    public function findAll(){
        $sql = 'SELECT * FROM users';
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    //参照（条件付き）
    public function findById($id){
        $sql = 'SELECT * FROM users WHERE id = :id';
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

    //編集　update
    public function edit($arr){
        $sql = "UPDATE users SET user_name = :user_name, email = :email, password = :password, updated = :updated WHERE id = :id";
        $stmt = $this->connect->prepare($sql);
        $params = array(
            ':id'=>$arr['id'],
            ':user_name'=>$arr['user_name'], 
            ':email'=>$arr['email'], 
            ':password'=>$arr['password'], 
            
            ':updated'=>date('Y-m-d H:i:s')
        );
        $stmt->execute($params);
    }
    


    //削除するメソッド
    public function delete($id = null){
        if(isset($id)){
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = $this->connect->prepare($sql);
            $params = array (':id'=>$id);
            $stmt->execute($params);
        }
    }
}
?>