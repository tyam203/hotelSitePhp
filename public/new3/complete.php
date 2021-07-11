<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
date_default_timezone_set('Asia/Tokyo');
$birthday = $_POST['birthday'];
$gender = $_POST['gender'];
$bookingDate = date("Y-m-d H:i:s");
// 同行者の数を計算,POSTでそれぞれの値を取得
$travelWith = $_SESSION['totalNumber'] - 1;
for ($i = 1; $i <= $travelWith; $i++){
        $_POST['name' . $i];
        $_POST['birthday' . $i];
        $_POST['gender' . $i];
    }

// 空室確認、空室がなければエラーメッセージ表示
$sql = "SELECT * FROM stock";
$sql .= " WHERE date BETWEEN'" . $_SESSION['checkInDate'] . "'AND'" . $_SESSION['checkOutBefore'] . "'";
$sql .= " AND stock >='" . $_SESSION['roomNumber'] . "'";
$result =$db->query($sql);
// var_dump($result);exit;
if ($result->num_rows === 0 ) {
    echo '<p>空室がありません。検索条件を変えてやり直してください</p>';
    echo '<a href="index.php">トップページへ</a>';
    exit;
} 

// bookingテーブルに挿入
$sql = "INSERT INTO booking";
$sql .= " VALUES(NULL, '%s', '%s', '%d', '%d', '%d', '%d', '%s', '%s');";
$result = $db->query(sprintf(
    $sql,
    $_SESSION['checkInDate'],
    $_SESSION['checkOutDate'],
    $_SESSION['totalNumber'],
    $_SESSION['totalPrice'],
    $_SESSION['roomId'],
    $_SESSION['roomNumber'],
    "reserved",
    $bookingDate,
));
// var_dump($sql);exit;
$sql = " SELECT last_insert_id() FROM booking";
$result = $db->query($sql);
$datas = $result->fetch_object();
foreach($datas as $data){
    $bookingId = $data;
}

// memberテーブルに挿入
$sql = "INSERT INTO member";
$sql .= " VALUES('%d', '%d', '%s', '%d', '%s', '%s', '%d');";
$result = $db->query(sprintf(
    $sql,
    $bookingId,
    $_SESSION['id'],
    $_POST['name'],
    $gender,
    $birthday,
    $_POST['email'],
    $_POST['tel'],
));
// travelWithテーブルに挿入
$travelWith = $_SESSION['totalNumber'] - 1;
if($travelWith !== 0) {
    for ($i = 1; $i <= $travelWith; $i++){
        $sql = "INSERT INTO travelWith";
        $sql .= " VALUES(NULL, '%d', '%s', '%d', '%s');";
        $result = $db->query(sprintf(
            $sql,
            $bookingId,
            $_POST['name' . $i],
            $_POST['gender' . $i],
            $_POST['birthday' . $i],
        ));
    }
}
// stockテーブルを更新
$sql = "UPDATE stock SET stock = stock -'" . $_SESSION['roomNumber'] . "'";
$sql .= " WHERE stock.date BETWEEN'" . $_SESSION['checkInDate'] . "'AND'" . $_SESSION['checkOutBefore'] . "'";
$sql .= " AND stock.roomId ='" . $_SESSION['roomId'] . "'";
$result = $db->query($sql);  
if ($result === false) {
    echo 'データの送信に失敗しました';
}

?>
<h2>予約完了画面</h2>
<h3>以下の内容でご予約が完了しました</h3>
<h4>予約内容</h4>
<p>ホテル名：<?= $_SESSION['hotelName']; ?></p>	
<p>宿泊プラン：<?= $_SESSION['roomType']; ?></p>	
<p>宿泊日：<?= formatDate($_SESSION['checkInDate']) ?></p>	
<p>泊数：<?= $_SESSION['stayDate']; ?>泊</p>	
<p>部屋数：<?= $_SESSION['roomNumber']; ?>部屋</p>	
<p>大人：<?= $_SESSION['totalAdult']; ?>名</p>	
<p>こども(ベッドあり)：<?= $_SESSION['totalChild']; ?>名</p>	
<p>こども(ベッドなし)：<?= $_SESSION['totalNoBed']; ?>名</p>	
<p>合計金額：<?= $_SESSION['totalPrice']; ?>円</p>

<h4>お客様情報</h4>
<h5>代表者</h5>
<p>氏名：<?= $_POST['name'] ?></p>
<p>年齢：<?= ageCalculate($birthday) ?></p>
<p>性別：<?= genderCheck($gender) ?></p>

<?php 
for ($i = 1; $i <= $travelWith; $i++){
    echo '<h5>同行者' . $i . '</h5>';
    echo '<p>氏名：' . $_POST['name' . $i] . '</p>';
    echo '<p>年齢：' . ageCalculate($_POST['birthday' . $i]) . '</p>';
    if ($_POST['gender' . $i] === "1"){
        $gender = "男性";
    } 
    if ($_POST['gender' . $i] === "2") {
        $gender = "女性";
    }
    echo '<p>性別：' . $gender . '</p>';
}
?>
<a href="index.php">トップページに戻る</a>  