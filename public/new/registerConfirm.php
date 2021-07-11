<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>
<main>
<h2>登録内容確認</h2>
    <form action="registerComplete.php" method="post">
        <dl>
            <dt>氏名</dt>
            <dd><?= $_POST['name'] ?></dd>
            <dt>生年月日</dt> 
            <dd><?= $_POST['birthday'] ?></dd>

            <dt>性別</dt> 
            <dd><?= genderCheck($_POST['gender']) ?></dd>
            
            <dt>メールアドレス</dt>
            <dd><?= $_POST['email'] ?></dd>

            <dt>電話番号</dt>
            <dd><?= $_POST['tel'] ?></dd>
            
            <dt>パスワード</dt>
            <dd><?= $_POST['password'] ?></dd>
        </dl>
        <input type="hidden" name="name" value="<?= $_POST['name'] ?>">
        <input type="hidden" name="birthday" value="<?= $_POST['birthday'] ?>">
        <input type="hidden" name="gender" value="<?= $_POST['gender'] ?>">
        <input type="hidden" name="email" value="<?= $_POST['email'] ?>">
        <input type="hidden" name="tel" value="<?= $_POST['tel'] ?>">
        <input type="hidden" name="password" value="<?= $_POST['password'] ?>">
        <input type="submit" value="会員登録完了">
    </form>
</main>
</body>
</html>