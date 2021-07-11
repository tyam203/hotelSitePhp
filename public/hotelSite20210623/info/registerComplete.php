<?php
require_once('../common/common.php');
require_once('../common/info.php');
if (empty($_POST) === false) {
$sql = "INSERT INTO register";
$sql .= " VALUES(NULL, '%s', '%s', '%d', '%s', '%d', '%s');";
$result = $db->query(sprintf(
    $sql,
    $_POST['name'],
    $_POST['birthday'],
    $_POST['gender'],
    $_POST['email'],
    $_POST['tel'],
    $_POST['password'],
));
if ($result === false) {
    echo 'データの送信に失敗しました';
} else {
    $sql = " SELECT last_insert_id() FROM register";
    $result = $db->query($sql);
    $datas = $result->fetch_object();
    foreach($datas as $data){
        $loginId = $data;
    }
    $_SESSION['login'] = "ok";
    $_SESSION['id'] = $loginId;
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];

}
} else {
echo 'フォームの受取に失敗しました';
}
?>

<main>
    <h2>会員登録完了</h2>
    <p>会員登録が完了しました。</p>
    <button><a href="../form.php">予約手続きへ進む</a></button>
</main>

</body>
</header>
