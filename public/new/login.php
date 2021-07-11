<!-- ログインページ -->

<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
// すでにログインしていた場合、ログイン済みと表示するページへ飛ぶ
// if (isset($_SESSION['id'])) {
// 	header('Location: loggingIn.php');
//     exit;
// } 
// ログインフォームに値が入っていたら
if (!empty($_POST) === true) {
    // フォーム両方とも値が入っていたら
    if($_POST['email'] != '' && $_POST['password'] != '') {
        // 行いたい処理
        try {
            // メールアドレスとパスワードがデータベースに存在し、一致していれば抽出
            $sql = "SELECT * FROM register WHERE email = '" . $_POST['email'] . "'";
            $sql .= "AND password = '" . $_POST['password'] ."'";
            $result = $db->query($sql);
            // 値が抽出できていない場合エラー
            if ($result->num_rows == 0) {
                throw new Exception('Query Error');
            }
            // 抽出できていればセッションにログインOK、idとユーザー名を焼いて、トップページへ移動する
            elseif ($result->num_rows > 0) {
                $data = $result->fetch_object();
                $_SESSION['login'] = 'ok';
                $_SESSION['id'] = $data->id;
                $_SESSION['name'] = $data->name;
                header('Location: form.php'); exit();
            } 
        } catch(Exception $e) {
            echo 'メールアドレスとパスワードが一致しません。';
        }
    } else{
        echo '未記入の項目があります';
    }
}
?>

    <main>
        <h1>ログイン</h1>
        <p>メールアドレスとパスワードをご入力ください</p>
        <p>会員登録がまだの場合は<a href="register.php">こちら</a>よりご登録ください</p>
        <form action="" method="post">
            <dl>
            <dt>メールアドレス</dt>
            <dd>
            <input type="email" name="email">
            </dd>
            <dt>パスワード</dt>
            <dd>
            <input type="password" name="password">
            </dd>
            </dl>
            <input type="submit" value="ログイン">
        </form>
    </main>
</body>
</html>
