<main>
<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
$id = $_GET['id'];
$checkInDate = $_GET['date'];
$year = date('Y', strtotime($checkInDate));
$month = date('n', strtotime($checkInDate));

$prev = date('Y-m-d', strtotime($checkInDate . '-1 month'));
$next = date('Y-m-d', strtotime($checkInDate . '+1 month'));

$sql = "SELECT * FROM room";
$sql .= " WHERE id = $id";
$result = $db->query($sql);
$data = $result->fetch_object();

echo '<h2>旅行代金</h2>';
echo '<p>ホテル:  ' . $data->hotel . '</p>';
echo '<p>部屋タイプ:  ' . $data->room_type . '</p>';
echo '<p>' . $_SESSION['number'] . '名/1室利用</p>';

echo '<p><a href="detail.php?id=' . $id . '&date=' . $prev . '">&nbsp;&lt;&nbsp;</a>';
echo $year . '年' . $month . '月';
echo '<a href="detail.php?id=' . $id . '&date=' . $next . '">&nbsp;&gt;</a></p>';

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
    $sql = " SELECT * FROM price WHERE date ='" . date('Y-m-d', $ts) . "'";
    $sql .= " AND roomId ='" . $id . "'";
    $result = $db->query($sql);
    $data = $result->fetch_object();
    if (!empty($data->price)) {
        $totalPrice = $data->price * $_SESSION['roomNumber'] * $_SESSION['stayDate']; 
        echo '<div>' . $totalPrice . '円</div>';
        echo '<a href="confirm.php?date=' . date('Y-m-d', $ts) . '&room=' . $id . '">予約する</a>';
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