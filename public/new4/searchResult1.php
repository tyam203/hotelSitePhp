<!-- ２段階で検索条件の絞り込み・取得する方法の実験 -->

<?php
require_once('common/common.php');


// チェックイン日取得
$checkInDate = $_GET['checkInDate'];
$formedCheckInDate = date('Y年n月j日', strtotime($checkInDate));
$stayCount = $_GET['stayCount'];
$roomNumber = $_GET['roomNumber'];
// チェックアウト日計算
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayCount . 'day'));
// チェックアウト前日計算
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));

// 大人の合計人数を計算
$totalAdult = 0;
for($i = 1; $i <= 5; $i++){
    $totalAdult += $_GET['room' . $i . 'Adult'];
}
// // こども（ベッドあり）の合計人数を計算
$totalChild = 0;
for($i = 1; $i <= 5; $i++){
    $totalChild += $_GET['room' . $i . 'Child'];
}
// // こども（ベッドなし）の合計人数を計算
$totalNoBed = 0;
for($i = 1; $i <= 5; $i++){
    $totalNoBed += $_GET['room' . $i . 'NoBed'];
}
// ベッドが必要な人数を計算、capacityで絞り込む際に使用
$numberOfBed1 = $_GET['room1Adult'] + $_GET['room1Child'];
$numberOfBed2 = $_GET['room2Adult'] + $_GET['room2Child'];
$numberOfBed3 = $_GET['room3Adult'] + $_GET['room3Child'];
$numberOfBed4 = $_GET['room4Adult'] + $_GET['room4Child'];
$numberOfBed5 = $_GET['room5Adult'] + $_GET['room5Child'];
// 5部屋のうち、もっともベッド所要人数が多い部屋を計算、capacityで絞り込む際に使用
$numberOfBed = max($numberOfBed1, $numberOfBed2, $numberOfBed3, $numberOfBed4, $numberOfBed5);
$totalCount = $totalAdult + $totalChild + $totalNoBed;


// 都道府県名取得
$prefectureId = $_GET['prefecture'];
$sql = "SELECT prefectureName FROM hotel";
$sql .= " WHERE prefectureId = $prefectureId";
$result = $db->query($sql);
$data = $result->fetch_object();
$prefectureName = $data->prefectureName;
// roomテーブル・priceテーブルより要素を取得
// 都道府県・チェックイン日（日付指定の場合）が一致する日付の最高値・最安値を取得
$sql2 = "SELECT room. hotel_id AS hotelId, room.id AS roomId, hotel.hotelName, price.stock, price.date FROM room";
// $sql2 = "SELECT  hotel.*, room. hotel_id AS hotelId, price.stock, MIN(price.price), MAX(price.price) FROM room";
$sql2 .= " JOIN hotel";
$sql2 .= " ON hotel.id = room.hotel_id";
$sql2 .= " JOIN price";
$sql2 .= " ON room.id = price.roomId";
$sql2 .= " WHERE hotel.prefectureId ='" . $prefectureId . "'";
// 最大収容人数の要件を満たしているかチェック
$sql2 .= " AND room.capacity  >='" . $numberOfBed . "'";
// 検索条件で日付指定している場合
if (!empty($checkInDate)) {
    $sql2 .= " AND price.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
} 
// ホテルごとにグループ化
// $sql2 .= " GROUP BY room.id";
// $sql2 .= " GROUP BY hotelId";
// var_dump($sql2);exit;
$result = $db->query($sql2);
    // $data = $result->fetch_object();
    // exit;
while ($data = $result->fetch_object()){
    if($data->stock >= $roomNumber) {
        var_dump($data);
        echo '<br>';
    }
}
exit;
require_once('common/header.php');
?>

<main>
    <h2>検索条件</h2>
    <?php if (!empty($checkInDate)):?>
        <p>宿泊日：<?= $formedCheckInDate?> </p>
        <?php else:?>
        <p>宿泊日：指定なし</p>
    <?php endif; ?>

    <p>泊数：<?= $stayCount ?>泊</p>
    <p>都道府県：<?= $prefectureName ?></p>
    <p>部屋数：<?= $roomNumber ?>部屋</p>
    <p>大人：<?= $totalAdult ?>名</p>

    <!-- こども（ベッドあり）がいる場合 -->
    <?php if (!empty($totalChild)):?>
        <p>こども(ベッドあり)：<?= $totalChild?>名</p>
    <?php endif;?>
    <!-- こども（ベッドなし）がいる場合 -->
    <?php if (!empty($totalNoBed)):?>
        <p>こども（ベッドなし）：<?= $totalNoBed ?>名</p>
    <?php endif;?>
    <input type="button" onclick="history.back()" value="検索条件を変更する">
    <!-- <a href="index.php">検索条件を変更する</a> -->
    <hr>


    <h3>該当ホテル</h3>
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($data = $result->fetch_object()): ?>
                <li>
                <p>ホテル名:<?= $data->hotelName ?></p>
                <form method="GET" action="stayPlan.php">
                <?php if (!empty($checkInDate)): ?>
                    <input type="hidden" name="checkInDate" value="<?= $checkInDate ?>">
                <?php endif; ?>
                <input type="hidden" name="hotelId" value="<?= $data->hotelId ?>">
                <input type="hidden" name="stayCount" value="<?= $stayCount ?>">
                <input type="hidden" name="roomNumber" value="<?= $roomNumber ?>">
                <input type="hidden" name="totalAdult" value="<?= $totalAdult ?>">
                <input type="hidden" name="totalChild" value="<?= $totalChild ?>">
                <input type="hidden" name="totalNoBed" value="<?= $totalNoBed ?>">
                <input type="hidden" name="numberOfBed" value="<?= $numberOfBed ?>">
                <button type=submit">宿泊プラン一覧はこちら</button>
                </form>
                </li>
                <br>
                <hr>
            <?php endwhile; ?>
        <?php else: ?>
            <p>条件に一致するホテルがありませんでした</p>
            <p>条件を変更して再検索してください</p>
        <?php endif; ?> 
   </ul>
</main>
</body>
</html>

