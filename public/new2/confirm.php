<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();

$_SESSION['roomId'] = $_GET['roomId'];
if(empty($_SESSION['checkInDate'])) {
    $_SESSION['checkInDate'] = $_GET['date'];
    $checkOutDate = date('Y-m-d', strtotime($_SESSION['checkInDate'] . '+' . $_SESSION['stayDate'] . 'day'));
    $_SESSION['checkOutDate'] = $checkOutDate;
    $checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));
    $sql = "SELECT *, SUM(price) AS total FROM room2";
    $sql .= " JOIN hotel2";
    $sql .= " ON room2.hotel_id = hotel2.id";
    $sql .= " JOIN price2";
    $sql .= " ON room2.id = price2.roomId";
    $sql .= " WHERE room2.id ='" . $_GET['roomId'] . "'";
    $sql .= " AND price2.date BETWEEN'" . $_SESSION['checkInDate'] . "'AND'" . $checkOutBefore . "'";
    $result = $db->query($sql);
    $data = $result->fetch_object();
    $_SESSION['hotelName'] = $data->hotelName;
    $_SESSION['totalPrice'] = $data->total * $_SESSION['roomNumber'];
}

?>
<main>	
<h2>選択内容確認画面</h2>	
	
<p>ホテル名：<?php echo $_SESSION['hotelName']; ?></p>	

<?php
$checkOutBefore = date('Y-m-d', strtotime($_SESSION['checkOutDate'] . '-1day'));

$sql = "SELECT SUM(price) AS total, room_type AS roomType FROM room2";
$sql .= " JOIN price2";
$sql .= " ON room2.id = price2.roomId";
$sql .= " WHERE room2.id ='" . $_SESSION['roomId'] . "'";
$sql .= " AND price2.date BETWEEN'" . $_SESSION['checkInDate'] . "'AND'" . $checkOutBefore . "'";
// var_dump($sql);
$result = $db->query($sql);
$data = $result->fetch_object();
$_SESSION['roomType'] = $data->roomType;
$_SESSION['totalPrice'] = $data->total * $_SESSION['roomNumber'];

?>
<p>宿泊プラン：<?= $_SESSION['roomType'] ?></p>	
<p>チェックイン日：<?php echo $_SESSION['checkInDate']; ?></p>	
<p>チェックアウト日：<?php echo $_SESSION['checkOutDate']; ?></p>	
	
<p>泊数：<?php echo $_SESSION['stayDate']; ?>泊</p>	
	
	
<p>部屋数：<?php echo $_SESSION['roomNumber']; ?>部屋</p>	
<p>大人：<?php echo $_SESSION['totalAdult']; ?>名</p>	
<p>こども(ベッドあり)：<?php echo $_SESSION['totalChild']; ?>名</p>	
<p>こども(ベッドなし)：<?php echo $_SESSION['totalNoBed']; ?>名</p>	
<p>合計金額：<?php echo $_SESSION['totalPrice']; ?>円</p>
<button><a href="register.php">新規会員登録はこちら</a></button>
<button><a href="login.php">会員登録済みの方はこちら</a></button>


</main>	
<script type="text/javascript" src="js/hotel.js"></script>	
</body>	
</html>	