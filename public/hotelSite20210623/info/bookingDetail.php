<?php
require_once('../common/common.php');
require_once('../common/info.php');

$sql = " SELECT * FROM booking";
$sql .= " JOIN room";
$sql .= " ON room.id = booking.roomId";
$sql .= " JOIN hotel";
$sql .= " ON hotel.id = room.hotel_id";
$sql .= " WHERE booking.id ='" . $_GET['bookingId'] . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
?>

<main>
<h2>予約詳細</h2>
<p>日程：<?= formatDate($data->checkInDate) ?>～<?= formatDate($data->checkOutDate) ?></p>
<p>宿泊先：<?= $data->hotelName ?></p>
<p>人数：<?= $data->guestCount ?>名</p>
<p>部屋数：<?= $data->roomCount ?>部屋</p>
<p>代表者：<?= $data->userName ?></p>
<p>支払金額：<?= $data->price ?>円</p>
<p>予約番号：<?= $_GET['bookingId'] ?></p>
<p>予約日：<?= formatDate($data->bookingDate); ?></p>
<input type="button" onclick="history.back()" value="前のページに戻る">
</main>
</body>
</html>
