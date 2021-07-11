<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>

<main>
<?php
// ホテルIDを取得
$hotelId = $_GET['hotelId'];
$checkInDate = $_GET['checkInDate'];
$stayDate = $_GET['stayDate'];
$roomNumber = $_GET['roomNumber'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayDate . 'day'));
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));

// キャンセル料金発生日の計算
$inCharge = date('Y年n月j日', strtotime($checkInDate . '-8 day'));

// roomテーブル・priceテーブルよりホテルIDとチェックイン日の条件が合致するものを取得
$sql = "SELECT SUM(price) AS total, hotel.hotelName AS hotelName, hotel.id AS hotelId, price.roomId AS roomId, room.room_type AS roomType FROM price";
$sql .= " JOIN room";
$sql .= " ON  price.roomId = room.id";
$sql .= " JOIN hotel";
$sql .= " ON hotel.id = room.hotel_id";
$sql .= " WHERE price.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
$sql .= " AND room.hotel_id = $hotelId";
$sql .= " GROUP BY price.roomId";
$result = $db->query($sql);
$data = $result->fetch_object();
$hotelName = $data->hotelName;
echo '<h2>' . $hotelName .'</h2>';
echo '<p>チェックイン日：' . date('Y年n月j日', strtotime($checkInDate)) . '</p>';
echo '<p>チェックアウト日：' . date('Y年n月j日', strtotime($checkOutDate)) . '</p>';

$result = $db->query($sql);
$data = $result->fetch_object();
    echo '<form method="get" action="confirm.php">';
    echo '<input type="hidden" name="checkInDate" value="' . $checkInDate . '">';
    echo '<input type="hidden" name="checkOutDate" value="' . $checkOutDate . '">';
    echo '<input type="hidden" name="stayDate" value="' . $stayDate . '">';
    echo '<input type="hidden" name="roomNumber" value="' . $roomNumber . '">';
    echo '<input type="hidden" name="roomId" value="' . $data->roomId . '">';
    echo '<p>部屋タイプ：' . $data->roomType . '</p>';

    // 合計金額
    $totalPrice = $data->total * $roomNumber;
    echo '<p>料金:' . $totalPrice . '円(' . $roomNumber . '部屋/' . $stayDate .'泊)</p>';
    echo '<p>' . $inCharge . 'までキャンセル無料</p>';
    echo '<input type="submit" value="予約に進む"><br>';
    echo '<button><a href="detail.php?roomId=' . $data->roomId . '&checkInDate=' . $checkInDate . '&stayDate=' . $stayDate . '&roomNumber=' . $roomNumber . '&hotel=' . $data->hotelId . 
    '">ほかの日付の料金も見る</a></button>';
    echo '</form>';
?>
</main>
</body>
</html>