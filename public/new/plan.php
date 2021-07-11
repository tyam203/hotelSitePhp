<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>

<main>
<?php
// ホテルIDを取得
$hotelId = $_GET['hotelId'];
// $date = $_SESSION['checkInDate'];
$checkInDate = $_SESSION['checkInDate'];
$checkOutDate = date('Y-m-d', strtotime($checkInDate . '+' . $_SESSION['stayDate'] . 'day'));
$checkOutBefore = date('Y-m-d', strtotime($checkOutDate . '-1day'));

// キャンセル料金発生日の計算
$inCharge = date('Y年n月j日', strtotime($checkInDate . '-8 day'));

// roomテーブル・priceテーブルよりホテルIDとチェックイン日の条件が合致するものを取得
$sql = "SELECT SUM(price) AS total, hotel2.hotelName AS hotelName, hotel2.id AS hotelId, price2.roomId AS roomId, room2.room_type AS roomType FROM price2";
// $sql = "SELECT *, price2.id AS priceId FROM price2";
$sql .= " JOIN room2";
$sql .= " ON  price2.roomId = room2.id";
$sql .= " JOIN hotel2";
$sql .= " ON hotel2.id = room2.hotel_id";
$sql .= " WHERE price2.date BETWEEN'" . $checkInDate . "'AND'" . $checkOutBefore . "'";
// $sql .= " WHERE price2.date ='" . $_SESSION['checkInDate'] . "'";
$sql .= " AND room2.hotel_id = $hotelId";
$sql .= " GROUP BY price2.roomId";

// ２泊以上の時に使う条件分岐・ループ文
// if($_SESSION['stayDate'] > 1) {
    //     for ($i = 1; $i < $_SESSION['stayDate']; $i++) { 
        //         $_SESSION['date'. $i] = date('Y-m-d', strtotime($checkInDate . + $i . 'day'));
        //         $sql = "SELECT * FROM price2";
        //         $sql .= " JOIN room2";
        //         $sql .= " ON price2.roomId = room2.id";
        //         $sql .= " WHERE price2.date ='" . $_SESSION['date' . $i] . "'";
        //         $sql .= " AND room2.hotel_id = $hotelId";
        //         $result = $db->query($sql);
        //         $data = $result->fetch_object();
        //     }
        // } 
        // var_dump($sql);
        // foreach($datas as $data){
            //     var_dump($data);exit;
            // }
$result = $db->query($sql);
$data = $result->fetch_object();
echo '<h2>' . $data->hotelName .'</h2>';
echo '<p>チェックイン日：' . date('Y年n月j日', strtotime($checkInDate)) . '</p>';
echo '<p>チェックアウト日：' . date('Y年n月j日', strtotime($checkOutDate)) . '</p>';

echo '<ul>';
$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<li>';
    echo '<form method="get" action="confirm.php">';
    // echo '<input type="hidden" name="priceId" value="' . $data->priceId . '">';
    echo '<input type="hidden" name="roomId" value="' . $data->roomId . '">';
    echo '<p>部屋タイプ：' . $data->roomType . '</p>';

    // 合計金額=「初日の代金 + n泊目の代金 × 部屋数」
    $totalPrice = $data->total * $_SESSION['roomNumber'];

    // $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
    $_SESSION['totalPrice'] = $totalPrice;
    // $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
    // $_SESSION['totalPrice'] = $totalPrice;
    // echo '<input type="hidden" name="totalPrice" value="' . $totalPrice . '">';
    echo '<p>料金:' . $totalPrice . '円(' . $_SESSION['roomNumber'] . '部屋/' . $_SESSION['stayDate'] .'泊)</p>';
    echo '<p>' . $inCharge . 'までキャンセル無料</p>';
    echo '<input type="submit" value="予約する"><br>';
    // echo '<a href="detail.php?id=' . $data->roomId . '&date=' . $date . '&hotel=' . $data->hotel_id . 
    // '">ほかの日付の料金も見る</a>';
    echo '<button><a href="detail.php?id=' . $data->roomId . '&date=' . $checkInDate . '&hotel=' . $data->hotelId . 
    '">ほかの日付の料金も見る</a></button>';
    echo '</form>';
    echo '</li>';
}
echo '</ul>';
?>
</main>
</body>
</html>