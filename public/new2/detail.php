<main>
<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
$roomId = $_GET['id'];
$_SESSION['roomId'] = $roomId;
$checkInDate = $_GET['date'];
$year = date('Y', strtotime($checkInDate));
$month = date('n', strtotime($checkInDate));

$prev = date('Y-m-d', strtotime($checkInDate . '-1 month'));
$next = date('Y-m-d', strtotime($checkInDate . '+1 month'));

$sql = "SELECT * FROM room2";
$sql .= " JOIN hotel2";
$sql .= " ON hotel2.id = room2.hotel_id";
$sql .= " WHERE room2.id = $roomId";
$result = $db->query($sql);
$data = $result->fetch_object();

echo '<h2>旅行代金</h2>';
echo '<p>ホテル:  ' . $data->hotelName . '</p>';
echo '<p>部屋タイプ:  ' . $data->room_type . '</p>';
// echo '<p>泊数:  ' . $_SESSION['stayDate'] . '泊</p>';
echo '<p>部屋数:  ' . $_SESSION['roomNumber'] . '部屋</p>';
echo '<p>' . $_SESSION['number'] . '名/1室利用</p>';

echo '<p><button><a href="detail.php?id=' . $roomId . '&date=' . $prev . '">&nbsp;&lt;&nbsp;</a></button>';
echo '<button>' . $year . '年' . $month . '月</button>';
echo '<button><a href="detail.php?id=' . $roomId . '&date=' . $next . '">&nbsp;&gt;</a></button></p>';


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

$ts = mktime(0, 0, 0, $month, 1, $year);
$endTs = mktime(0, 0, 0, $month + 1, 1, $year);


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
    $sql = " SELECT * FROM price2 WHERE date ='" . date('Y-m-d', $ts) . "'";
    $sql .= " AND roomId ='" . $roomId . "'";
    $result = $db->query($sql);
    $data = $result->fetch_object();
    if (!empty($data->price)) {
        // $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
        $totalPrice = $data->price * $_SESSION['roomNumber']; 
        echo '<div>' . $totalPrice . '円</div>';
        echo '<a href="confirm.php?date=' . date('Y-m-d', $ts) . '&roomId=' . $roomId . '">予約する</a>';
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