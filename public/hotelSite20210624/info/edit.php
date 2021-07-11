<?php
require_once('../common/common.php');
require_once('../common/info.php');
$registrationNumber = $_GET['registerId'];

// 現在の登録情報を取得
$sql = " SELECT * FROM register";
$sql .= " WHERE id='" . $registrationNumber . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
$name = $data->name;
$birthday = $data->birthday;
$gender = $data->gender;
$tel = $data->tel;
$email = $data->email;
$password = $data->password;
?>

<main>
<h2>会員情報変更</h2>
<form method="POST" action="editConfirm.php">
<p>名前: <input type="text" name="name" value="<?= $name ?>"></p>
<p>生年月日: <input type="date" name="birthday" value="<?= $birthday ?>"></p>
<p>性別：
<input type="radio" name="gender" value="1">男性
<input type="radio" name="gender" value="2">女性
</p>
<p>電話番号:<input type="tel" name="tel" value="<?= $tel ?>"></p>
<p>メールアドレス: <input type="email" name="email" value="<?= $email ?>"></p>
<p>パスワード: <input type="password" name="password" value="<?= $password ?>"></p>
<input type="submit" value="変更を完了する">
<input type="button" onclick="history.back()" value="マイページに戻る">
</form>

</main>
</body>
</html>