<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
$_SESSION['stayDate'] = $_GET['stayDate'];
$_SESSION['roomNumber'] = $_GET['roomNumber'];
$checkInDate = $_GET['checkInDate'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $_SESSION['stayDate'] . 'day'));
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));

$prefectureId = $_GET['prefecture'];
$sql = "SELECT name, hotel2.id AS hotelId, hotel2.hotelName FROM prefecture";
$sql .= " JOIN hotel2";
$sql .= " ON prefecture.id = hotel2.prefectureId";
$sql .= " WHERE prefecture.id = $prefectureId";
// var_dump($sql);
$result = $db->query($sql);
// $data = $result->fetch_object();
// $_SESSION['prefectureId'] = $prefectureId;

while($data = $result->fetch_object()){
    // var_dump($data);exit;
    $hotelId = $data->hotelId;
    $prefecture = $data->name;
    // echo $hotelId;
    // $_SESSION['checkInDate'] = $_GET['checkInDate'];

    $sql2 = "SELECT SUM(price) AS total, hotel2.hotelName AS hotelName, hotel2.id AS hotelId, price2.roomId AS roomId FROM price2";
    // $sql2 = "SELECT *, price2.id AS priceId FROM price2";
    $sql2 .= " JOIN room2";
    $sql2 .= " ON  price2.roomId = room2.id";
    $sql2 .= " JOIN hotel2";
    $sql2 .= " ON hotel2.id = room2.hotel_id";
    $sql2 .= " WHERE price2.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
    // $sql2 .= " AND room2.hotel_id = $hotelId";
    $sql2 .= " AND hotel2.prefectureId ='" . $prefectureId . "'";
    // $sql2 .= " AND hotel2.prefectureId ='" . $_SESSION['prefectureId'] . "'";
    $sql2 .= " GROUP BY hotelId";
    // $sql2 .= " GROUP BY price2.roomId";
    $sql2 .= " HAVING hotelId = $hotelId";
    // $sql2 .= " ORDER BY roomId";
    $result2 = $db->query($sql2);
    while($data2 = $result2->fetch_object()){
        var_dump($data2);
    }
}
// var_dump($data);exit;


// var_dump($data);exit;
// $sql .= " GROUP BY room2.id";
// チェックイン日の表示フォーマットを年月日に変更

// 大人の合計人数を計算
$totalAdult = 0;
$totalAdult += $_GET['room1Adult'];
$totalAdult += $_GET['room2Adult'];
$totalAdult += $_GET['room3Adult'];
$totalAdult += $_GET['room4Adult'];
$totalAdult += $_GET['room5Adult'];
$_SESSION['totalAdult'] = $totalAdult;

// こども（ベッドあり）の合計人数を計算
$totalChild = 0;
$totalChild += $_GET['room1Child'];
$totalChild += $_GET['room2Child'];
$totalChild += $_GET['room3Child'];
$totalChild += $_GET['room4Child'];
$totalChild += $_GET['room5Child'];
$_SESSION['totalChild'] = $totalChild;

// こども（ベッドなし）の合計人数を計算
$totalNoBed = 0;
$totalNoBed += $_GET['room1NoBed'];
$totalNoBed += $_GET['room2NoBed'];
$totalNoBed += $_GET['room3NoBed'];
$totalNoBed += $_GET['room4NoBed'];
$totalNoBed += $_GET['room5NoBed'];
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
?>

<main>
    <h2>検索条件</h2>
    <?php if (!empty($checkInDate)) {
        // <?php if (!empty($_SESSION['checkInDate'])) {
            $formedCheckInDate = date('Y年n月j日', strtotime($checkInDate));
            // $checkInDate = date('Y年n月j日', strtotime($_SESSION['checkInDate']));
            echo '<p>宿泊日：' . $formedCheckInDate . '</p>';
        } else {
            echo '<p>宿泊日：指定なし</p>';
        }
        ?>
    <p>泊数：<?php echo $_SESSION['stayDate'] ?>泊</p>
    <p>都道府県：<?php echo $prefecture ?></p>
    <p>部屋数：<?php echo $_SESSION['roomNumber'] ?>部屋</p>
    <p>大人：<?php echo $_SESSION['totalAdult'] ?>名</p>

    <!-- こども（ベッドあり）がいる場合 -->
    <?php if (!empty($_SESSION['totalChild'])) {
        echo '<p>こども（ベッドあり）：' . $_SESSION['totalChild'] . '名</p>';
    } 
    ?>
    <!-- こども（ベッドなし）がいる場合 -->
    <?php if (!empty($_SESSION['totalNoBed'])) {
        echo '<p>こども（ベッドあり）：' . $_SESSION['totalNoBed'] . '名</p>';
    } 
    ?>
    <a href="index.php">検索条件を変更する</a>

    <h3>該当ホテル</h3>
    <ul>
    <?php

        $sql = "SELECT *, SUM(price) AS total, hotel2.hotelName AS hotelName, hotel2.id AS hotelId, price2.roomId AS roomId FROM price2";
        // $sql = "SELECT *, price2.id AS priceId FROM price2";
        $sql .= " JOIN room2";
        $sql .= " ON  price2.roomId = room2.id";
        $sql .= " JOIN hotel2";
        $sql .= " ON hotel2.id = room2.hotel_id";
        $sql .= " WHERE price2.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
        // $sql .= " AND room2.hotel_id = $hotelId";
        $sql .= " AND hotel2.prefectureId ='" . $prefectureId . "'";
        // $sql .= " AND hotel2.prefectureId ='" . $_SESSION['prefectureId'] . "'";
        // $sql .= " GROUP BY price2.roomId";


        // roomテーブル・priceテーブルより要素を取得
        // 都道府県・チェックイン日（日付指定の場合）が一致する日付の最高値・最安値を取得
        // $sql = "SELECT *, MAX(price) AS max, MIN(price) AS min FROM room2";
        // $sql .= " JOIN price2";
        // $sql .= " ON room2.id = price2.roomId";
        // $sql .= " JOIN stock";
        // $sql .= " ON room2.id = stock.roomId";
        // $sql .= " JOIN hotel2";
        // $sql .= " ON hotel2.id = room2.hotel_id";
        // $sql .= " WHERE hotel2.prefectureId ='" . $_SESSION['prefectureId'] . "'";
        
        
        // 検索条件で日付指定している場合
        // if (!empty($_SESSION['checkInDate'])) {
        //     $sql .= " AND price2.date ='" . $_SESSION['checkInDate'] . "'";
        // } 

        // 部屋の残数の要件を満たしているかチェック
        // $sql .= " AND stock.stock >='" . $_SESSION['roomNumber'] . "'";
        // 最大収容人数の要件を満たしているかチェック
        $sql .= " AND room2.capacity  >='" . $numberOfBed . "'";
        // 部屋タイプごとにグループ化
        $sql .= " GROUP BY room2.id";
        // var_dump($sql);exit;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_object()) {
                $totalPrice = $data->total;
                // echo $totalPrice;
                echo '<br>';
                // var_dump($data);
                echo '<li>';
                echo '<p>ホテル名:' . $data->hotelName . '</p>' ;
                // 最安値を計算
                // $totalMinPrice = $data->min * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
                // 最高値を計算
                // $totalMaxPrice = $data->max * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
                // echo '<p>合計金額:' . $totalMinPrice . '円～' . $totalMaxPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] . '泊)</p>';
                echo '<p>部屋タイプ:' . $data->room_type . '</p>';
                echo '<p>合計金額:' . $data->total . '円</p>';
                if (!empty($checkInDate)) {
                    echo '<a href="plan.php?hotelId=' . $data->hotelId . '">宿泊プラン一覧はこちら</a>';
                }
                // 日付指定をしていない場合
                else{
                    echo '<a href="plan2.php?hotelId=' . $data->hotelId . '">宿泊プラン一覧はこちら</a>';
                }
                echo '</li>';
                echo '<br>';
            }
        } else{
            echo '<p>条件に一致するホテルがありませんでした</p>';
        }
    ?>
    </ul>
</main>
</body>
</html>
