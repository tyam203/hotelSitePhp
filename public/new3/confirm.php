<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
$_SESSION['roomId'] = $_GET['roomId'];
$_SESSION['roomNumber'] = $_GET['roomNumber'];
$checkInDate = $_GET['checkInDate'];
$stayDate = $_GET['stayDate'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayDate . 'day'));
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));
// $checkOutDate = $_GET['checkOutDate'];
$_SESSION['checkInDate'] = $checkInDate;
$_SESSION['checkOutDate'] = $checkOutDate;
$_SESSION['checkOutBefore'] = $checkOutBefore;
$_SESSION['stayDate'] = $stayDate;

?>
<main>	
<h2>選択内容確認画面</h2>	

<?php
$sql = "SELECT SUM(price) AS total, room_type AS roomType, hotel.hotelName AS hotelName FROM room";
$sql .= " JOIN price";
$sql .= " ON room.id = price.roomId";
$sql .= " JOIN hotel";
$sql .= " ON room.hotel_id = hotel.id";
$sql .= " WHERE room.id ='" . $_SESSION['roomId'] . "'";
$sql .= " AND price.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
$_SESSION['hotelName'] = $data->hotelName;
$_SESSION['roomType'] = $data->roomType;
$_SESSION['totalPrice'] = $data->total * $_SESSION['roomNumber'];

?>
<p>ホテル名：<?php echo $_SESSION['hotelName']; ?></p>	
<p>宿泊プラン：<?= $_SESSION['roomType'] ?></p>	
<p>チェックイン日：<?= formatDate($checkInDate) ?></p>	
<p>チェックアウト日：<?=  formatDate($checkOutDate) ?></p>	
	
<p>泊数：<?php echo $stayDate; ?>泊</p>	
	
	
<p>部屋数：<?php echo $_SESSION['roomNumber']; ?>部屋</p>	
<p>大人：<?php echo $_SESSION['totalAdult']; ?>名</p>	
<p>こども(ベッドあり)：<?php echo $_SESSION['totalChild']; ?>名</p>	
<p>こども(ベッドなし)：<?php echo $_SESSION['totalNoBed']; ?>名</p>	
<p>合計金額：<?php echo $_SESSION['totalPrice']; ?>円</p>
<?php
if (!empty($_SESSION['login'])){
    echo '<button><a href="form.php">予約者情報記入へ</a></button>';
} else{
    echo '<button><a href="register.php">新規会員登録はこちら</a></button>';
    echo '<button><a href="login.php">会員登録済みの方はこちら</a></button>';
}
?>


</main>	
<script type="text/javascript" src="js/hotel.js"></script>	
</body>	
</html>	