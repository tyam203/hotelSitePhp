<main>
<?php
require_once('common/common.php');
require_once('common/header.php');
$roomId = $_GET['roomId'];
$checkInDate = $_GET['checkInDate'];
$stayCount = $_GET['stayCount'];
$roomNumber = $_GET['roomNumber'];
$totalAdult = $_GET['totalAdult'];
$totalChild = $_GET['totalChild'];
$totalNoBed = $_GET['totalNoBed'];
$numberOfBed = $_GET['numberOfBed'];
// $_SESSION['roomId'] = $roomId;
$year = date('Y', strtotime($checkInDate));
$month = date('n', strtotime($checkInDate));

// 予約可能日のタイムスタンプを取得（３日先から予約可能）
$today = time();
$bookable = $today + 3600 * 24 * 2;

$startTs = mktime(0, 0, 0, $month - 1, 1, $year);
$ts = mktime(0, 0, 0, $month, 1, $year);
$endTs = mktime(0, 0, 0, $month + 1, 1, $year);
$prev = date('Y-m-d', $startTs);
$next = date('Y-m-d', $endTs);

// ホテルIDを取得
$sql = "SELECT *, hotel.id AS hotelId FROM room";
$sql .= " JOIN hotel";
$sql .= " ON hotel.id = room.hotel_id";
$sql .= " WHERE room.id = $roomId";
$result = $db->query($sql);
$data = $result->fetch_object();
$hotelId = $data->hotelId;




echo '<h2>旅行代金</h2>';
echo '<p>ホテル:  ' . $data->hotelName . '</p>';
echo '<p>部屋タイプ:  ' . $data->room_type . '</p>';
echo '<p>泊数:  ' . $stayCount . '泊</p>';
echo '<p>部屋数:  ' . $roomNumber . '部屋</p>';
echo '<p>' . $numberOfBed . '名/1室利用</p>';
// 実験段階で、日付決まっている場合もplan2.phpに戻る
// 必要な情報　hotelId=1&stayCount=1&roomNumber=1　特にhotelId
echo '<a href="plan2.php?stayCount=' . $stayCount . '&roomNumber=' . $roomNumber . '&hotelId=' . $hotelId . '">部屋タイプ選択に戻る</a>';

echo '<p><button><a href="detail.php?roomId=' . $roomId . '&checkInDate=' . $prev . '&stayCount=' . $stayCount . '&roomNumber=' . $roomNumber . '">&nbsp;&lt;&nbsp;</a></button>';
echo '<button>' . $year . '年' . $month . '月</button>';
echo '<button><a href="detail.php?roomId=' . $roomId . '&checkInDate=' . $next . '&stayCount=' . $stayCount . '&roomNumber=' . $roomNumber . '">&nbsp;&gt;</a></button></p>';
echo '<p>○：残室 10 以上 ×：残室なし</p>';

echo '<table border="1">';
echo '<tr>';
echo '<th>日</th>';
echo '<th>月</th>';
echo '<th>火</th>';
echo '<th>水</th>';
echo '<th>木</th>';
echo '<th>金</th>';
echo '<th>土</th>';
echo '</tr>';

// $today = time();
// $ts = mktime(0, 0, 0, $month, 1, $year);
// $endTs = mktime(0, 0, 0, $month + 1, 1, $year);

for (; $ts < $endTs; $ts = $ts += 3600 * 24) {
    if (date('w', $ts) == 0) {
        echo '<tr>';
    }

    // 1日の時だけ
    if (date('j', $ts) == 1) {
        for ($i = 0; $i < date('w', $ts); $i++) {
            echo '<td></td>';
        }
    } 
    echo '<td width="100px" height="50px">';
    echo '<div>' . date('j', $ts) . '</div>';
    $sql = " SELECT *, room.hotel_id AS hotelId, price.date AS priceDate FROM price";
    $sql .= " JOIN room";
    $sql .= " ON price.roomId = room.id";
    $sql .= " WHERE price.date ='" . date('Y-m-d', $ts) . "'";
    $sql .= " AND price.roomId ='" . $roomId . "'";
    // var_dump($sql);
    $result = $db->query($sql);
    $data = $result->fetch_object();
    if (!empty($data->price)) {
        // $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayCount']; 
        $totalPrice = $data->price * $roomNumber; 
        $stock = $data->stock;
        if ($stock >= 10) {
            $stock = "〇";
        } elseif($stock > 0) {
            $stock = $data->stock . '室';
        } else{
            $stock = "×";
        }   
        if ($ts <= $bookable) {
            echo '<div>予約不可</div>';
            echo '<div>-</div>';

        } else{

            // echo '<a href="confirm.php?checkInDate=' . date('Y-m-d', $ts) . '&stayCount=' . $stayCount . '&roomNumber=' . $roomNumber . '&roomId=' . $roomId . '">予約する</a>';
            echo '<a href="confirm.php?checkInDate=' . date('Y-m-d', $ts) . '&stayCount=' . $stayCount . '&roomNumber=' . $roomNumber . '&roomId=' . $roomId . '">';
            echo '<div>' . $totalPrice . '円</div>';
            echo '<div>' . $stock . '</div>';
            echo '</a>';
        }
    } else {
        echo '<div>設定なし</div>';
    }
    echo '</td>';

    // 月末の時だけ
    if(date('j' , $ts) == date('t', $ts)) {
        for ($i = date('w', $ts); $i < 6 - date('w', $ts); $i++) {
            echo '<td></td>';
        }
    }


    if (date('w', $ts) == 6) {
        echo '</tr>';
    }
}
 
echo '</table>';
?>
</main>
</body>
</html>