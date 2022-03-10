<?php
session_start();


require_once("../config/config.php");
require_once("../model/user.php");
try {
    $user = new User($host, $dbname, $portNumber, $user, $pass);
    $user->connectDb();
    
    if($_POST){
        $result = $user->login($_POST);
        
        if(!empty($result)){
            $_SESSION['User'] = $result;
            header('Location:/study/php-zissen/users/index.php');
            exit;
        }else{
            $message = "ログイン却下！";
        }
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
    <title>ログイン　サンプル</title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <h1>ログイン</h1>
    </header>

    <section class="user">
        <h2>ログインフォーム</h2>

        <p>ログインするには以下にユーザ名とパスワードを入力してね！</p>
        <?php if(isset($message)) echo "<p class='error'>".$message."</p>" ?>
        <form action="" method="POST">
            <table>
                <tr>
                    <th>ユーザ名</th>
                    <td><input type="text" name="user_name" size="20"></td>
                </tr>
                    <tr><th>パスワード</th>
                    <td><input type="password" name="password" size="20"></td>
                </tr>
            </table>
            <p><input type="submit" value="ログインダァ！"></p>
        </form>

    </section>

    <footer>
        <p>sample 2019.</p>
    </footer>
</body>

</html>