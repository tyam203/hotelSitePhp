<?php
require_once('../common/common.php');
$sql = "SELECT * FROM booking";
$sql .= " JOIN room ON booking.roomId = room.id ";
$sql .= " JOIN hotel";
$sql .= " ON room.hotel_id = hotel.id";
$sql .= " WHERE 1 = 1";
if ($_POST['bookingId']) {
    $sql .= " AND booking.id ='" . $_POST['bookingId'] . "'";
}
if ($_POST['name']) {
    $sql .= " AND userName ='" . $_POST['name'] . "'";
}
if ($_POST['phoneNumber']) {
    $sql .= " AND userPhoneNumber ='" . $_POST['phoneNumber'] . "'";
}
if ($_POST['checkInDate']) {
    $sql .= " AND checkInDate ='" . $_POST['checkInDate'] . "'";
}
$result = $db->query($sql);
if ($result->num_rows > 0){
    $data= $result->fetch_object();
} else {
    echo '条件に合致する記録がありませんでした';
    exit;
}
?>
<main>
<h2>予約詳細</h2>
<p>日程：<?= formatDate($data->checkInDate) ?>～<?= formatDate($data->checkOutDate) ?></p>
<p>宿泊先：<?= $data->hotelName ?></p>
<p>人数：<?= $data->guestCount ?>名</p>
<p>部屋数：<?= $data->roomCount ?>部屋</p>
<p>代表者：<?= $data->userName ?></p>
<p>支払金額：<?= $data->price ?>円</p>
<p>予約番号：<?= $data->id ?></p>
<p>予約日：<?= formatDate($data->bookingDate); ?></p>
<input type="button" onclick="history.back()" value="前のページに戻る">
</main>
</body>
</html>