<?php
session_start();

require_once("../config/config.php");
require_once("../model/product.php");

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
    $product = new Product($host, $dbname, $portNumber, $user, $pass);
    $product->connectDb();

    $result = $product->findAll();
    
    

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
        <a href="">ユーザ一覧</a>
        <a href="">商品一覧</a>
    </section>
    <section class="user">
        <h2>商品一覧</h2>
        <p><a href="?logout=1">ログアウト</a></p>
      

        <table>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>価格</th>
            </tr>
            <?php foreach($result as $row):?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['price']?></td>
            </tr>
            <?php endforeach?>
        </table>
    </section>

    <footer>
        <p>sample 2022.</p>
    </footer>
</body>
</html>