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


?>

<main>
    <h2>旅行代金</h2>
    <p>ホテル:<?= $data->hotelName ?></p>
    <p>部屋タイプ:<?=  $data->room_type ?></p>
    <p>泊数:<?= $stayCount ?>泊</p>
    <p>部屋数:<?= $roomNumber ?>部屋</p>
    <p><?= $numberOfBed ?>名/1室利用</p>
    <input type="button" onclick="history.back()" value="部屋タイプ選択に戻る">
    
    <!-- 前月・翌日ページ遷移ボタン -->
    <p><button><a href="detail.php?roomId=<?= $roomId ?>&checkInDate=<?= $prev ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&numberOfBed=<?= $numberOfBed ?>&totalAdult=<?= $totalAdult ?>&totalChild=<?= $totalChild ?>&totalNoBed=<?= $totalNoBed ?>">&nbsp;&lt;&nbsp;</a></button>
    <button><?= $year ?>年<?= $month ?>月</button>
    <button><a href="detail.php?roomId=<?= $roomId ?>&checkInDate=<?= $next ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&numberOfBed=<?= $numberOfBed ?>&totalAdult=<?= $totalAdult ?>&totalChild=<?= $totalChild ?>&totalNoBed=<?= $totalNoBed ?>">&nbsp;&gt;</a></button></p>
    <p>○：残室 10 以上 ×：残室なし</p>
    
    <table border="1">
        <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
        </tr>
        
        
        <?php for (; $ts < $endTs; $ts = $ts += 3600 * 24): ?>
            <?php if (date('w', $ts) == 0) : ?>
                <tr>
                    <?php endif; ?>
                    
                    <!-- 1日の時だけ -->
                    <?php if (date('j', $ts) == 1): ?>
                        <?php for ($i = 0; $i < date('w', $ts); $i++) :?>
                            <td></td>
                            <?php endfor; ?>
                            <?php endif; ?> 
                            <td width="100px" height="50px">
                                <div><?= date('j', $ts) ?></div>
    <?php
    $sql1 = " SELECT *, room.hotel_id AS hotelId, price.date AS priceDate FROM price";
    $sql1 .= " JOIN room";
    $sql1 .= " ON price.roomId = room.id";
    $sql1 .= " WHERE price.date ='" . date('Y-m-d', $ts) . "'";
    $sql1 .= " AND price.roomId ='" . $roomId . "'";
    $result1 = $db->query($sql1);
    $data1 = $result1->fetch_object();
    ?>
    <?php if (!empty($data1->price)): ?>
        <?php $totalPrice = $data1->price * $roomNumber; ?> 
        <?php $stock = $data1->stock;?>
        <?php if ($stock >= 10): ?>
            <?php $stock = "〇"; ?>
        <?php elseif($stock > 0): ?>
            <?php $stock = $data1->stock . '室'; ?>
        <?php else: ?>
            <?php $stock = "×"; ?>
        <?php endif; ?>   
        <?php if ($ts <= $bookable): ?>
            <div>予約不可</div>
            <div>-</div>

        <?php else: ?>
            <a href="confirm.php?checkInDate=<?= date('Y-m-d', $ts) ?>&stayCount=<?= $stayCount ?>&roomNumber=<?= $roomNumber ?>&roomId=<?= $roomId ?>&totalAdult=<?= $totalAdult ?>&totalChild=<?= $totalChild ?>&totalNoBed=<?= $totalNoBed ?>">
            <div><?= $totalPrice ?>円</div>
            <div><?= $stock ?></div>
            </a>
        <?php endif; ?>
    <?php else: ?>
        <div>設定なし</div>
    <?php endif; ?>
    </td>

     <!-- 月末の時だけ -->
    <?php if(date('j' , $ts) == date('t', $ts)): ?>
        <?php for ($i = date('w', $ts); $i < 6 - date('w', $ts); $i++): ?>
            <td></td>
        <?php endfor;?>
    <?php endif; ?>


    <?php if (date('w', $ts) == 6): ?>
        </tr>
    <?php endif; ?>
<?php endfor; ?>
 
</table>
</main>
</body>
</html>