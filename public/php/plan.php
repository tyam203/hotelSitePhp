<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>

<main>
<?php
// ホテルIDを取得
$id = $_GET['id'];
$checkInDate = $_SESSION['checkInDate'];

// キャンセル料金発生日の計算
$inCharge = date('Y年n月j日', strtotime($checkInDate . '-8 day'));

// roomテーブル・priceテーブルよりホテルIDとチェックイン日の条件が合致するものを取得
$sql = "SELECT * FROM room";
$sql .= " JOIN price";
$sql .= " ON room.id = price.roomId";
$sql .= " WHERE hotel_id = $id";
$sql .= " AND price.date ='" . $_SESSION['checkInDate'] . "'";

$result = $db->query($sql);
$data = $result->fetch_object();
echo '<h1>' . $data->hotel .'</h1>';

$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<form method="post" action="confirm.php">';
    echo '<input type="hidden" name="priceId" value="' . $data->id . '">';
    echo '<p>部屋タイプ：' . $data->room_type . '</p>';
    $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
    echo '<input type="hidden" name="totalPrice" value="' . $totalPrice . '">';
    echo '<p>料金:' . $totalPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] .'泊)</p>';
    echo '<p>' . $inCharge . 'までキャンセル無料</p>';
    echo '<input type="submit" value="予約する"><br>';
    echo '<a href="detail.php?id=' . $data->roomId . '&date=' . $checkInDate . '&hotel=' . $data->hotel . '&room=' . $data->room_type . 
    '">ほかの日付の料金も見る</a>';
    echo '</form>';
}
?>
</main>
</body>
</html>