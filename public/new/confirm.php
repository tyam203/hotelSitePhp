<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
var_dump($_SESSION);

if (!empty($_GET['priceId'])){
    $id = $_GET['priceId'];
    $sql = " SELECT * FROM price2";
    $sql .= " JOIN room2";
    $sql .= " ON price2.roomId = room2.id";
    $sql .= " JOIN hotel2";
    $sql .= " ON hotel2.id = room2.hotel_id";
    $sql .= " WHERE price2.id = $id";
} else {
    $id = $_GET['room'];
    $date = $_GET['date'];
    $sql = " SELECT * FROM price2";
    $sql .= " JOIN room2";
    $sql .= " ON price2.roomId = room2.id";
    $sql .= " JOIN hotel2";
    $sql .= " ON hotel2.id = room2.hotel_id";
    $sql .= " WHERE room2.id = $id";
    $sql .= " AND date = '$date'";
    $_SESSION['checkInDate'] = $date;
}
$result = $db->query($sql);
$data = $result->fetch_object();
// $totalPrice = $_SESSION['totalPrice'];
$totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
$_SESSION['totalPrice'] = $totalPrice;
$_SESSION['hotelName'] = $data->hotelName;
$_SESSION['roomType'] = $data->room_type;
$_SESSION['roomId'] = $data->roomId;
$_SESSION['priceId'] = $id;
?>
<main>	
<h2>選択内容確認画面</h2>	
	
<p>ホテル名：<?php echo $_SESSION['hotelName']; ?></p>	
	
<p>宿泊プラン：<?php echo $_SESSION['roomType']; ?></p>	
<?= $_SESSION['roomId'] ?>
<p>宿泊日：<?php echo $_SESSION['checkInDate']; ?></p>	
	
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