<!-- 新規会員登録ページ -->

<?php
require_once('common/common.php');
require_once('common/header.php');
// 未記入の項目があった場合、次のconfirm.phpにて$_SESSION['error']を焼き、エラーメッセージ表示
session_start();
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
} 
?>


        <main>
            <h2>新規会員登録</h2>
            <form action="registerConfirm.php" method="post">
                <dl>
                    <dt>氏名</dt>
                    <dd>
                    <input type="text" name="name">
                    </dd>
                    <dt>生年月日</dt>
                    <dd>
                    <input type="date" name="birthday">
                    </dd>
                    <dt>性別</dt>
                    <dd>
                    <input type="radio" name="gender" value="1">男性
                    <input type="radio" name="gender" value="2">女性
                    </dd>
                    <dt>メールアドレス</dt>
                    <dd>
                    <input type="email" name="email">
                    </dd>
                    <dt>電話番号</dt>
                    <dd>
                    <input type="tel" name="tel">
                    </dd>
                    <dt>パスワード</dt>
                    <dd>
                    <input type="password" name="password">
                    </dd>
                </dl>
                <input type="submit" value="入力内容確認">
            </form>
        </main>
    </body>
</html>