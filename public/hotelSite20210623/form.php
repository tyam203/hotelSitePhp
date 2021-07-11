<?php
require_once('common/common.php');
require_once('common/header.php');
$sql = " SELECT * FROM register";
$sql .= " WHERE id='" . $_SESSION['id'] . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
    
$travelWith = $_SESSION['totalNumber'] - 1;
?>
<main>
<h2>お客様情報入力</h2>
<h3>代表者</h3>
<form action="complete.php" method="post">
    <dl>
        <dt>氏名</dt>
        <dd><input type="text" name="name" value="<?= $data->name ?>"></dd>

        <dt>生年月日</dt> 
        <dd><input type="date" name="birthday" value="<?= $data->birthday ?>"></dd>

        <dt>性別</dt> 
        <dd>
        <input type="radio" name="gender" value="1">男性
        <input type="radio" name="gender" value="2">女性
        </dd>

        <dt>メールアドレス</dt>
        <dd><input type="email" name="email" value="<?= $data->email ?>"></dd>

        <dt>電話番号</dt>
        <dd><input type="tel" name="tel" value="<?= $data->tel ?>"></dd>
    </dl>

    <?php if ($travelWith !== 0): ?>
        <?php for ($i = 1; $i <= $travelWith; $i++): ?>
            <h3>同行者<?= $i ?></h3> 
            <?php travelWithForm($i); ?>  
        <?php endfor; ?>
    <?php endif; ?>
<input type="submit" value="予約完了">
</form>
</main>
</body>
</html>