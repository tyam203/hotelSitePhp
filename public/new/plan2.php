<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>

<main>
<?php
// ホテルIDを取得
$id = $_GET['hotelId'];
$checkInDate = date('Y-m-d');
$sql = "SELECT *, MAX(price) AS max, MIN(price) AS min FROM room2";
$sql .= " JOIN price2";
$sql .= " ON room2.id = price2.roomId";
$sql .= " JOIN hotel2";
$sql .= " ON hotel2.id = room2.hotel_id";
$sql .= " WHERE hotel_id = $id";
$sql .= " GROUP BY roomId";


$result = $db->query($sql);
$data = $result->fetch_object();
echo '<h1>' . $data->hotelName .'</h1>';

$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<form method="post" action="detail.php?id=' . $data->roomId . '&date=' . $checkInDate . '&hotel=' . $data->hotelName . '&room=' . $data->roomId . '">';
    echo '<p>部屋タイプ：' . $data->room_type . '</p>';
    $totalMinPrice = $data->min * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
    $totalMaxPrice = $data->max * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
    $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
    echo '<p>料金:' . $totalMinPrice . '円～' . $totalMaxPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] . '泊)</p>';
    echo '<p>宿泊8日前までキャンセル無料</p>';
    echo '<input type="submit" value="空室カレンダー"><br>';
    echo '</form>';
    echo '<br>';
}
