<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
if (!empty($_POST['priceId'])){
    $id = $_POST['priceId'];
    $sql = " SELECT * FROM price";
    $sql .= " WHERE id = $id";
} else {
    $id = $_GET['room'];
    $date = $_GET['date'];
    $sql = " SELECT * FROM price";
    $sql .= " WHERE roomId = $id";
    $sql .= " AND date = '$date'";
    $_SESSION['checkInDate'] = $date;
}
$result = $db->query($sql);
$data = $result->fetch_object();
$totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
$_SESSION['roomType'] = $data->roomType;
$_SESSION['totalPrice'] = $totalPrice;
?>
<main>	
<h2>選択内容確認画面</h2>	

<form method="POST" action="booking.php">	
	
	
<p>宿泊プラン：<?php echo $_SESSION['roomType']; ?></p>	
	
<p>宿泊日：<?php echo $_SESSION['checkInDate']; ?></p>	
	
<p>泊数：<?php echo $_SESSION['stayDate']; ?>泊</p>	
	
	
<p>部屋数：<?php echo $_SESSION['roomNumber']; ?>部屋</p>	
<p>大人：<?php echo $_SESSION['totalAdult']; ?>名</p>	
<p>こども(ベッドあり)：<?php echo $_SESSION['totalChild']; ?>名</p>	
<p>こども(ベッドなし)：<?php echo $_SESSION['totalNoBed']; ?>名</p>	
<p>合計金額：<?php echo $_SESSION['totalPrice']; ?>円</p>
<button type="submit" class="btn btn-submit" id="check">この内容で予約する</button>	
</form>	
	

</main>	
<script type="text/javascript" src="js/hotel.js"></script>	
</body>	
</html>	