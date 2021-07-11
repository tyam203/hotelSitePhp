<?php
require_once('common/common.php');
// ホテルIDを取得
$hotelId = $_GET['hotelId'];
$checkInDate = $_GET['checkInDate'];
$stayCount = $_GET['stayCount'];
$roomNumber = $_GET['roomNumber'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayCount . 'day'));
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
$result2 = $db->query($sql);

require_once('common/header.php');
?>


<main>
<h2><?= $hotelName ?></h2>
<p>チェックイン日：<?= date('Y年n月j日', strtotime($checkInDate)) ?></p>
<p>チェックアウト日：<?= date('Y年n月j日', strtotime($checkOutDate)) ?></p>
<hr>

<?php while ($data = $result2->fetch_object()): ?>
    <form method="get" action="confirm.php">
    <input type="hidden" name="checkInDate" value="<?= $checkInDate ?>">
    <input type="hidden" name="checkOutDate" value="<?= $checkOutDate ?>">
    <input type="hidden" name="stayCount" value="<?= $stayCount ?>">
    <input type="hidden" name="roomNumber" value="<?= $roomNumber ?>">
    <input type="hidden" name="roomId" value="<?= $data->roomId ?>">
    <p>部屋タイプ：<?= $data->roomType ?></p>
    
    <!-- 合計金額 -->
    <?php $totalPrice = $data->total * $roomNumber; ?>
    <p>料金:<?= $totalPrice ?>円(<?= $roomNumber ?>部屋/<?= $stayCount ?>泊)</p>
    <p><?= $inCharge ?>までキャンセル無料</p>
    <input type="submit" value="予約に進む"><br>
    <button><a href="detail.php?roomId=<?= $data->roomId ?>&checkInDate=<?= $checkInDate ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&hotel=<?= $data->hotelId ?>">ほかの日付の料金も見る</a></button>
    </form>
    <hr>
<?php endwhile; ?>
</main>
</body>
</html>