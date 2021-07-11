<?php
require_once('../common/common.php');
require_once('../common/info.php');
// bookingテーブルのステータスをキャンセルに変える
$sql = " UPDATE booking SET status = 'canceled' WHERE id = '" . $_GET['bookingId'] .  "'";

// bookingテーブルからroomId、CheckInDate、checkOutDate、roomCountを取得
$sql1 = " SELECT roomId, checkInDate, checkOutDate, roomCount FROM booking";
$sql1 .= " WHERE id =  '" . $_GET['bookingId'] .  "'";
$result = $db->query($sql1);
$data = $result->fetch_object();
$roomId = $data->roomId;
$checkInDate = $data->checkInDate;
$checkOutDate = $data->checkOutDate;
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));
$roomCount = $data->roomCount;
// priceテーブルよりpriceIdを取得
$sql2 = " SELECT price.id AS priceId FROM booking";
$sql2 .= " JOIN room";
$sql2 .= " ON room.id = booking.roomId";
$sql2 .= " JOIN price";
$sql2 .= " ON price.roomId = room.id";
$sql2 .= " WHERE price.roomId = '" . $roomId  . "'";
$sql2 .= " AND price.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
$sql2 .= " AND booking.id = '" . $_GET['bookingId']  . "'";
$result2 = $db->query($sql2);
// $data = $result->fetch_object();
// $priceId = $data->priceId;

// キャンセルする場合、SQL文実行してマイページへ
if (!empty($_POST['yes']) === true){
    $result = $db->query($sql);
    while($data2 = $result2->fetch_object()){
            $priceId = $data2->priceId;
            $sql3 = " UPDATE price SET stock = stock + '" . $roomCount  . "'WHERE id = '" . $priceId  . "'";
            $result3 = $db->query($sql3);
        }
        header('Location: mypage.php');
        exit();
    } if (!empty($_POST['no']) === true){
        header('Location: mypage.php');
    }
        // priceテーブルのstockに、キャンセルした分の部屋数を返す。(priceIdが一致するもの）
// var_dump($sql3);exit;
?>
    
    <main>
        <form action="" method="post">
            <h2>キャンセル</h2>
            <p>本当に予約をキャンセルしますか？</p>
            <input type="submit" name="yes" value="はい">
            <input type="submit" name="no" value="いいえ">
        </form>
    </main>
</body>
</html>