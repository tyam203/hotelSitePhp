<?php
require_once('common/common.php');
session_start();
$id = $_GET['hotelId'];
$stayDate = $_GET['stayDate'];
$roomNumber = $_GET['roomNumber'];
$checkInDate = date('Y-m-d');
$sql = "SELECT *, MAX(price) AS max, MIN(price) AS min FROM room";
$sql .= " JOIN price";
$sql .= " ON room.id = price.roomId";
$sql .= " JOIN hotel";
$sql .= " ON hotel.id = room.hotel_id";
$sql .= " WHERE hotel_id = $id";
$sql .= " GROUP BY roomId";
$result = $db->query($sql);
$data = $result->fetch_object();
require_once('common/header.php');
?>

<main>
<!-- ホテルIDを取得 -->
<h1><?= $data->hotelName ?></h1>

<?php $result = $db->query($sql) ?>
<?php while ($data = $result->fetch_object()) :?>
    
    <form method="get" action="detail.php">
    <input type="hidden" name="roomId" value="<?= $data->roomId ?>">
    <input type="hidden" name="checkInDate" value="<?= $checkInDate ?>">
    <input type="hidden" name="stayDate" value="<?= $stayDate ?>">
    <input type="hidden" name="roomNumber" value="<?= $roomNumber ?>">
    <input type="hidden" name="hotel" value="<?= $data->hotelName ?>">
    <p>部屋タイプ：<?= $data->room_type ?></p>
    <!-- $totalMinPrice = $data->min * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
    $totalMaxPrice = $data->max * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
    $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
    echo '<p>料金:' . $totalMinPrice . '円～' . $totalMaxPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] . '泊)</p>'; -->
    <p>宿泊8日前までキャンセル無料</p>
    <input type="submit" value="空室カレンダー"><br>
    </form>
    <br>
<?php endwhile; ?>

</main>
</body>
</html>
