<!-- ログアウトページ -->
<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
// ログアウトする場合、セッション削除してトップページへ（ログインページへ）
if (!empty($_POST['yes']) === true){
    session_destroy();
    header('Location: index.php');
    exit();
} if (!empty($_POST['no']) === true){
    header('Location: index.php');
}
?>
    
    <main>
        <form action="" method="post">
            <h1>ログアウト</h1>
            <p>ログアウトしますか？</p>
            <input type="submit" name="yes" value="はい">
            <input type="submit" name="no" value="いいえ">
        </form>
    </main>
</body>
</html>
