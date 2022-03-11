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

    if($_POST){
        foreach($_POST as $key => $num){
            if($num > 0){
                $data = array('user_id'=>$_SESSION['User']['id'], 'product_id'=>$key, 'num'=>$num);
                $product->registerProduct($data);
            }
        }
            
        
    }

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
        <a href="/study/php-zissen/users">ユーザ一覧</a>
        <a href="/study/php-zissen/products">商品一覧</a>
    </section>
    <section class="user">
        <h2>商品一覧</h2>
        <p><a href="?logout=1">ログアウト</a></p>

        <form action="index.php" method="POST">
      
            <p><input type="submit" value="購入"></p>
            <table>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>個数</th>
                </tr>
                <?php foreach($result as $row):?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['name']?></td>
                    <td><?=$row['price']?></td>
                    <td><input type="text" size="5" name="<?=$row['id']?>" value="0">個</td>
                </tr>
                <?php endforeach?>
            </table>
        </form>
    </section>

    <footer>
        <p>sample 2022.</p>
    </footer>
</body>
</html>