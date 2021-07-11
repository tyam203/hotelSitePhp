<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();

$_SESSION['prefecture'] = $_POST['prefecture'];
$_SESSION['checkInDate'] = $_POST['checkInDate'];
$_SESSION['stayDate'] = $_POST['stayDate'];
$_SESSION['roomNumber'] = $_POST['roomNumber'];

// チェックイン日の表示フォーマットを年月日に変更
$checkInDate = date('Y年n月j日', strtotime($_SESSION['checkInDate']));

// 大人の合計人数を計算
$totalAdult = 0;
$totalAdult += $_POST['room1Adult'];
$totalAdult += $_POST['room2Adult'];
$totalAdult += $_POST['room3Adult'];
$totalAdult += $_POST['room4Adult'];
$totalAdult += $_POST['room5Adult'];
$_SESSION['totalAdult'] = $totalAdult;

// こども（ベッドあり）の合計人数を計算
$totalChild = 0;
$totalChild += $_POST['room1Child'];
$totalChild += $_POST['room2Child'];
$totalChild += $_POST['room3Child'];
$totalChild += $_POST['room4Child'];
$totalChild += $_POST['room5Child'];
$_SESSION['totalChild'] = $totalChild;

// こども（ベッドなし）の合計人数を計算
$totalNoBed = 0;
$totalNoBed += $_POST['room1NoBed'];
$totalNoBed += $_POST['room2NoBed'];
$totalNoBed += $_POST['room3NoBed'];
$totalNoBed += $_POST['room4NoBed'];
$totalNoBed += $_POST['room5NoBed'];
$_SESSION['totalNoBed'] = $totalNoBed;

// ベッドが必要な人数を計算、capacityで絞り込む際に使用
$numberOfBed1 = $_POST['room1Adult'] + $_POST['room1Child'];
$numberOfBed2 = $_POST['room2Adult'] + $_POST['room2Child'];
$numberOfBed3 = $_POST['room3Adult'] + $_POST['room3Child'];
$numberOfBed4 = $_POST['room4Adult'] + $_POST['room4Child'];
$numberOfBed5 = $_POST['room5Adult'] + $_POST['room5Child'];
// 5部屋のうち、もっともベッド所要人数が多い部屋を計算、capacityで絞り込む際に使用
$numberOfBed = max($numberOfBed1, $numberOfBed2, $numberOfBed3, $numberOfBed4, $numberOfBed5);
$_SESSION['number']= $numberOfBed;
?>

<main>
    <h2>検索条件</h2>
    <?php if (!empty($_SESSION['checkInDate'])) {
        echo '<p>宿泊日：' . $checkInDate . '</p>';
    } else {
        echo '<p>宿泊日：指定なし</p>';
    }
    ?>
    <p>泊数：<?php echo $_SESSION['stayDate'] ?>泊</p>
    <p>都道府県：<?php echo $_SESSION['prefecture'] ?></p>
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
        // roomテーブル・priceテーブルより要素を取得
        // 都道府県・チェックイン日（日付指定の場合）が一致する日付の最高値・最安値を取得
        $sql = "SELECT hotel, hotel_id, MAX(price) AS max, MIN(price) AS min FROM room";
        $sql .= " JOIN price";
        $sql .= " ON room.id = price.roomId";
        $sql .= " WHERE room.prefecture ='" . $_SESSION['prefecture'] . "'";

        // 検索条件で日付指定している場合
        if (!empty($_SESSION['checkInDate'])) {
        $sql .= " AND price.date ='" . $_SESSION['checkInDate'] . "'";
        } 
        // 最大収容人数の要件を満たしているかチェック
        $sql .= " AND room.capacity  >='" . $numberOfBed . "'";
        // 重複を避けるためホテルごとにグループ化
        $sql .= " GROUP BY hotel";
        
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_object()) {
                echo '<li>';
                echo '<p>ホテル名:' . $data->hotel . '</p>' ;
                // 最安値を計算
                $totalMinPrice = $data->min * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
                // 最高値を計算
                $totalMaxPrice = $data->max * $_SESSION['roomNumber'] * $_SESSION['stayDate'];
                echo '<p>合計金額:' . $totalMinPrice . '円～' . $totalMaxPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] . '泊)</p>';
                // 日付指定をしている場合
                if (!empty($_SESSION['checkInDate'])) {
                    echo '<a href="plan.php?id=' . $data->hotel_id . '">宿泊プラン一覧はこちら</a>';
                }
                // 日付指定をしていない場合
                else{
                    echo '<a href="plan2.php?id=' . $data->hotel_id . '">宿泊プラン一覧はこちら</a>';
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
