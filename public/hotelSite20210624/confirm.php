<?php
require_once('common/common.php');
$_SESSION['roomId'] = $_GET['roomId'];
$_SESSION['roomNumber'] = $_GET['roomNumber'];
$checkInDate = $_GET['checkInDate'];
$stayCount = $_GET['stayCount'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayCount . 'day'));
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));
$_SESSION['checkInDate'] = $checkInDate;
$_SESSION['checkOutDate'] = $checkOutDate;
$_SESSION['checkOutBefore'] = $checkOutBefore;
$_SESSION['stayCount'] = $stayCount;
$_SESSION['totalAdult'] = $_GET['totalAdult'];
$_SESSION['totalChild'] = $_GET['totalChild'];
$_SESSION['totalNoBed'] = $_GET['totalNoBed'];
$_SESSION['totalNumber'] = $_GET['totalAdult'] +  $_GET['totalChild'] + $_GET['totalNoBed'];

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
$_SESSION['price'] = $data->total;
$_SESSION['totalPrice'] = $_SESSION['price'] * $_SESSION['roomNumber'];

require_once('common/header.php');
?>

<main>	
<h2>選択内容確認</h2>	
<p>ホテル名：<?= $_SESSION['hotelName'] ?></p>	
<p>宿泊プラン：<?= $_SESSION['roomType'] ?></p>	
<p>チェックイン日：<?= formatDate($checkInDate) ?></p>	
<p>チェックアウト日：<?=  formatDate($checkOutDate) ?></p>	
<p>泊数：<?= $stayCount ?>泊</p>	
<p>合計人数:<?= $_SESSION['totalNumber'] ?>名</p>
<p>大人：<?= $_SESSION['totalAdult']?>名</p>
<?php if(isset($_SESSION['totalChild'])): ?>
<p>こども(ベッドあり)：<?= $_SESSION['totalChild']?>名</p>
<?php endif; ?> 
<?php if(isset($_SESSION['totalNoBed'])): ?>
<p>こども(ベッドなし)：<?= $_SESSION['totalNoBed']?>名</p>
<?php endif; ?> 
<p>合計金額：<?= $_SESSION['totalPrice'] ?>円(<?= $_SESSION['price']?>円×<?= $_SESSION['roomNumber'] ?>部屋)</p>
<?php if (!empty($_SESSION['login'])): ?>
   <button><a href="form.php">予約者情報記入へ</a></button>
   <input type="button" onclick="history.back()" value="戻る">
   <!-- <button><a href="form.php">訂正する</a></button> -->
<?php else: ?>
   <button><a href="info/register.php">新規会員登録はこちら</a></button>
   <button><a href="info/login.php">会員登録済みの方はこちら</a></button>
   <div><input type="button" onclick="history.back()" value="戻る"></div>
<?php endif; ?>

</main>	
</body>	
</html>	