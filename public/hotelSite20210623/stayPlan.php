<?php
require_once('common/common.php');
// ホテルIDを取得
$hotelId = $_GET['hotelId'];
$stayCount = $_GET['stayCount'];
$roomNumber = $_GET['roomNumber'];
$totalAdult = $_GET['totalAdult'];
$totalChild = $_GET['totalChild'];
$totalNoBed = $_GET['totalNoBed'];
$numberOfBed = $_GET['numberOfBed'];
if(!empty($_GET['checkInDate'])){
    $checkInDate = $_GET['checkInDate'];
    $checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayCount . 'day'));
    $checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));
    // キャンセル料金発生日前日の計算
    $inCharge = date('Y年n月j日', strtotime($checkInDate . '-8 day'));
}


// 日付指定の場合
$sql = "SELECT SUM(price) AS total, hotel.hotelName AS hotelName, hotel.id AS hotelId, price.roomId AS roomId, room.room_type AS roomType, image.imageName, image.detail, image.type FROM price";
$sql .= " JOIN room";
$sql .= " ON  price.roomId = room.id";
$sql .= " JOIN hotel";
$sql .= " ON hotel.id = room.hotel_id";
$sql .= " JOIN image";
$sql .= " ON image.hotelId = hotel.id";
$sql .= " WHERE room.hotel_id = '" . $hotelId . "'";
$sql .= " AND image.hotelId = '" . $hotelId . "'";
// $sql .= " AND image.type = 'main'";
if(!empty($checkInDate)){
    $sql .= " AND price.date BETWEEN '" . $checkInDate . "' AND '" . $checkOutBefore . "'";
}
$sql .= " GROUP BY roomId";
$result = $db->query($sql);
$data = $result->fetch_object();
$hotelName = $data->hotelName;
$result2 = $db->query($sql);

require_once('common/header.php');
?>


<main>
<h2><?= $hotelName ?></h2>
<p><img src="image/hotelId<?= $hotelId ?>/<?= $data->imageName ?>" alt="<?= $data->detail ?>" width="240px" height="180px"></p>
<?php if(!empty($checkInDate)): ?>
    <p>チェックイン日：<?= date('Y年n月j日', strtotime($checkInDate)) ?> </p>
    <p>チェックアウト日：<?= date('Y年n月j日', strtotime($checkOutDate)) ?> </p>
    <?php else: ?>
        <p>チェックイン日：未定</p>
        <p>泊数：<?= $stayCount ?>泊</p>
        <p>部屋数：<?= $roomNumber ?>部屋</p>
        <?php endif; ?>
        
        <input type="button" onclick="history.back()" value="ホテル選択に戻る">
        <hr>
        
        <?php while ($data = $result2->fetch_object()): ?>
            <form method="get" action="confirm.php">
                <input type="hidden" name="checkInDate" value="<?= $checkInDate ?>">
                <!-- <input type="hidden" name="checkOutDate" value="<?= $checkOutDate ?>"> -->
                <input type="hidden" name="stayCount" value="<?= $stayCount ?>">
                <input type="hidden" name="roomNumber" value="<?= $roomNumber ?>">
                <input type="hidden" name="roomId" value="<?= $data->roomId ?>">
                <input type="hidden" name="totalAdult" value="<?= $totalAdult ?>">
                <input type="hidden" name="totalChild" value="<?= $totalChild ?>">
                <input type="hidden" name="totalNoBed" value="<?= $totalNoBed ?>">
                <input type="hidden" name="numberOfBed" value="<?= $numberOfBed ?>">
                <p>部屋タイプ：<?= $data->roomType ?></p>
                <!-- <p><img src="" alt=""></p> -->
                <p><img src="image/hotelId<?= $hotelId ?>/<?= $data->imageName ?>" alt="<?= $data->detail ?>" width="240px" height="180px"></p>
                
                <!-- 合計金額 -->
                <?php if(!empty($checkInDate)): ?>
                    <?php $price = $data->total; ?>
                    <?php $totalPrice = $price * $roomNumber ?>
                    <p>料金:<?= $totalPrice ?>円(<?= $roomNumber ?>部屋/<?= $stayCount ?>泊)</p>
                    <p><?= $inCharge ?>までキャンセル無料</p>
                    <input type="submit" value="予約に進む"><br>
                    <button><a href="detail.php?roomId=<?= $data->roomId ?>&checkInDate=<?= $checkInDate ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&numberOfBed=<?= $numberOfBed ?>&hotel=<?= $data->hotelId ?>&totalAdult=<?= $totalAdult ?>&totalChild=<?= $totalChild ?>&totalNoBed=<?= $totalNoBed ?>">ほかの日付の料金も見る</a></button>    
                    
                    <?php else: ?>
        <p>宿泊8日前までキャンセル無料</p>
        <button><a href="detail.php?roomId=<?= $data->roomId  ?>&checkInDate=<?= date('Y-m-d') ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&hotel=<?= $data->hotelId ?>&numberOfBed=<?= $numberOfBed ?>&totalAdult=<?= $totalAdult ?>&totalChild=<?= $totalChild ?>&totalNoBed=<?= $totalNoBed ?>">空室カレンダー</a></button>
    <?php endif; ?>
    </form>
    <hr>
<?php endwhile; ?>
</main>
</body>
</html>