<?php
require_once('../common/common.php');
require_once('../common/info.php');


$sql = " UPDATE register";
$sql .= " SET name = '" . $_POST['name'] . "',";
$sql .= " birthday = '" . $_POST['birthday'] . "',";
$sql .= " gender = '" . $_POST['gender'] . "',";
$sql .= " tel = '" . $_POST['tel'] . "',";
$sql .= " email = '" . $_POST['email'] . "',";
$sql .= " password = '" . $_POST['password'] . "'"; 
$sql .= " WHERE register.id = '" . $_SESSION['id'] . "'";
$result = $db->query($sql);
?>

<main>
<h2>登録情報完了</h2>
<p><a href="mypage.php">マイページに戻る</a></p>
</main>
</body>
</html>