<?php
require_once('common/common.php');
session_start();

// 都道府県名取得
$prefectureId = $_GET['prefecture'];
$sql = " SELECT name FROM prefecture WHERE id = $prefectureId";
$result = $db->query($sql);
$data = $result->fetch_object();
$prefecture = $data->name;

$checkInDate = $_GET['checkInDate'];
$formedCheckInDate = date('Y年n月j日', strtotime($checkInDate));
$stayDate = $_GET['stayDate'];
$roomNumber = $_GET['roomNumber'];
// チェックアウト日計算
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $stayDate . 'day'));
// チェックアウト前日計算
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));

// 大人の合計人数を計算
$totalAdult = 0;
for($i = 1; $i <= 5; $i++){
    $totalAdult += $_GET['room' . $i . 'Adult'];
}
$_SESSION['totalAdult'] = $totalAdult;

// // こども（ベッドあり）の合計人数を計算
$totalChild = 0;
for($i = 1; $i <= 5; $i++){
    $totalChild += $_GET['room' . $i . 'Child'];
}
$_SESSION['totalChild'] = $totalChild;

// // こども（ベッドなし）の合計人数を計算
$totalNoBed = 0;
for($i = 1; $i <= 5; $i++){
    $totalNoBed += $_GET['room' . $i . 'NoBed'];
}
$_SESSION['totalNoBed'] = $totalNoBed;

// ベッドが必要な人数を計算、capacityで絞り込む際に使用
$numberOfBed1 = $_GET['room1Adult'] + $_GET['room1Child'];
$numberOfBed2 = $_GET['room2Adult'] + $_GET['room2Child'];
$numberOfBed3 = $_GET['room3Adult'] + $_GET['room3Child'];
$numberOfBed4 = $_GET['room4Adult'] + $_GET['room4Child'];
$numberOfBed5 = $_GET['room5Adult'] + $_GET['room5Child'];
// 5部屋のうち、もっともベッド所要人数が多い部屋を計算、capacityで絞り込む際に使用
$numberOfBed = max($numberOfBed1, $numberOfBed2, $numberOfBed3, $numberOfBed4, $numberOfBed5);
$_SESSION['number']= $numberOfBed;
$_SESSION['totalNumber'] = $totalAdult + $totalChild + $totalNoBed;

require_once('common/header.php');
?>

<main>
    <h2>検索条件</h2>

    <?php if (!empty($checkInDate)):?>
        <p>宿泊日：<?= $formedCheckInDate?> </p>
        <?php else:?>
        <p>宿泊日：指定なし</p>
    <?php endif; ?>

    <p>泊数：<?= $stayDate ?>泊</p>
    <p>都道府県：<?= $prefecture ?></p>
    <p>部屋数：<?= $roomNumber ?>部屋</p>
    <p>大人：<?= $_SESSION['totalAdult'] ?>名</p>

    <!-- こども（ベッドあり）がいる場合 -->
    <?php if (!empty($_SESSION['totalChild'])):?>
        <p>こども(ベッドあり)：<?= $_SESSION['totalChild']?>名</p>
    <?php endif;?>
    <!-- こども（ベッドなし）がいる場合 -->
    <?php if (!empty($_SESSION['totalNoBed'])):?>
        <p>こども（ベッドあり）：<?= $_SESSION['totalNoBed'] ?>名</p>
    <?php endif;?>
    <a href="index.php">検索条件を変更する</a>

    <h3>該当ホテル</h3>
    <ul>
    <?php
        // roomテーブル・priceテーブルより要素を取得
        // 都道府県・チェックイン日（日付指定の場合）が一致する日付の最高値・最安値を取得
        $sql = "SELECT  hotel.*, room. hotel_id AS hotelId, stock.stock, MIN(price.price), MAX(price.price) FROM room";
        $sql .= " JOIN hotel";
        $sql .= " ON hotel.id = room.hotel_id";
        $sql .= " JOIN stock";
        $sql .= " ON room.id = stock.roomId";
        
        
        // 検索条件で日付指定している場合
        if (!empty($checkInDate)) {
            $sql .= " JOIN price";
            $sql .= " ON price.roomId = room.id";
            $sql .= " WHERE stock.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
            $sql .= " AND price.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
        } 
        $sql .= " AND hotel.prefectureId ='" . $prefectureId . "'";
        
        // 部屋の残数の要件を満たしているかチェック
        $sql .= " AND stock.stock >='" . $roomNumber . "'";
        // 最大収容人数の要件を満たしているかチェック
        $sql .= " AND room.capacity  >='" . $numberOfBed . "'";
        // ホテルごとにグループ化
        // $sql .= " GROUP BY room.id";
        $sql .= " GROUP BY room.hotel_id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_object()) {
                // var_dump($data);
                echo '<li>';
                echo '<p>ホテル名:' . $data->hotelName . '</p>' ;

                // 日付指定をしている場合
                if (!empty($checkInDate)) {
                    // echo '<a href="plan.php?hotelId=' . $data->hotel_id . '&checkInDate=' . $checkInDate . '">宿泊プラン一覧はこちら</a>';
                    echo '<a href="plan.php?hotelId=' . $data->hotelId . '&checkInDate=' . $checkInDate . '&stayDate=' . $stayDate . '&roomNumber=' . $roomNumber . '">宿泊プラン一覧はこちら</a>';
                }
                // 日付指定をしていない場合
                else{
                    echo '<a href="plan2.php?hotelId=' . $data->hotelId . '&stayDate=' . $stayDate . '&roomNumber=' . $roomNumber . '">宿泊プラン一覧はこちら</a>';
                }
                echo '</li>';
                echo '<br>';
            }
        } else{
            echo '<p>条件に一致するホテルがありませんでした</p>';
            echo '<p>条件を変更して再検索してください</p>';
        }
    ?>
    </ul>
</main>
</body>
</html>
