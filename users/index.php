<?php
session_start();

require_once("../config/config.php");
require_once("../model/user.php");

//ログアウト処理
if(isset($_GET['logout'])){
    //セッション情報を破棄する
    $_SESSION = array();
    session_destroy();
}

//ログイン画面を経由しているかの確認
if(!isset($_SESSION['User'])){
    header('Location:/study/php-zissen/users/login.php');
    exit;
}
try {
    $user = new User($host, $dbname, $portNumber, $user, $pass);
    $user->connectDb();
    
    
    //編集処理
    if(isset($_GET['edit'])){
        //編集処理
        if($_POST){
            $message = $user->validate($_POST);
            if(empty($message['user_name']) && empty($message['email']) && empty($message['password'])) {
                $user->edit($_POST);
            }
        }    
    

        //参照処理
        $result['User'] = $user->findById($_GET['edit']);
    
    }
    //削除処理
    elseif(isset($_GET['del'])){
        $user->delete($_GET["del"]);
        //参照処理
        $result = $user->findAll();

    
    }
    //登録処理
    else{

        //登録処理
        if($_POST){
            $message = $user->validate($_POST);
            if(empty($message['user_name']) && empty($message['email']) && empty($message['password'])) {
                $user->add($_POST);
            }
        }
        //参照処理
        $result = $user->findAll();
    }
    

}catch(PDOException $e){
    print "エラー!". $e->getMessage()."<br/gt;";
    
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <title>サンプル</title>
</head>
<body>
    <header>
        <h1><a href="index.php">サンプル</a></h1>
    </header>
    <section class="category">
        <a href="/study/php-zissen/users">ユーザ一覧</a>
        <a href="/study/php-zissen/products">商品一覧</a>
    </section>
    <section class="user">
        <h2>ユーザ一覧</h2>
        <p><a href="?logout=1">ログアウト</a></p>

        <p>以下にユーザ情報を入力して送信を押すとユーザが登録できます。</p>
        <?php if(isset($message['user_name'])) echo "<p class='error'>".$message['user_name']."</p>" ?>
        <?php if(isset($message['email'])) echo "<p class='error'>".$message['email']."</p>" ?>
        <?php if(isset($message['password'])) echo "<p class='error'>".$message['password']."</p>" ?>

        <form action="" method="post">
            <label id="user_name">ユーザ名: <input type="text" name="user_name" size="20" value="<?php if(isset($result['User'])) echo $result['User']['user_name'] ?>"></label>
            <label id="email">メールアドレス: <input type="text" name="email" size="40" value="<?php if(isset($result['User'])) echo $result['User']['email'] ?>"></label>
            <label id ="password">パスワード: <input type="password" name="password" size="20" value="<?php if(isset($result['User'])) echo $result['User']['password'] ?>"></label>
            <input type="hidden" name="id" value="<?php if(isset($result['User'])) echo $result['User']['id'] ?>) ">
            <input type="submit" value="送信">
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>ユーザ名</th>
                <th>メールアドレス</th>
                <th>権限</th>
                <th></th>
            </tr>
            <?php foreach($result as $row):?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['user_name']?></td>
                <td><a href="<?=$row['email']?>"><?=$row['email']?></a></td>
                <td>
                    <?php if($row['role']==0):?>
                        管理者
                    <?php else: ?>
                        一般ユーザ
                    <?php endif ?>
                        
                </td>
                <td>
                    <a href="?edit=<?=$row['id']?>">編集</a>
                    <a href="?del=<?=$row['id']?>" onClick="if(!confirm('ユーザー名:<?=$row['user_name']?>を本当に削除していいの？')) return false">削除</a>
                </td>
            
            </tr>
            <?php endforeach?>
        </table>
    </section>

    <footer>
        <p>sample 2022.</p>
    </footer>
</body>
</html>