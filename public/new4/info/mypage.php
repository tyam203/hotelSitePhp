<?php
require_once('../common/common.php');
require_once('../common/info.php');

$registrationNumber = $_SESSION['id'];
// 登録情報を取得
$sql = " SELECT * FROM register";
$sql .= " WHERE id='" . $registrationNumber . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
$name = $data->name;
$birthday = $data->birthday;
$gender = $data->gender;
$tel = $data->tel;
$email = $data->email;

// 今日より先の出発の予約を取得
$today = date('Y-m-d');
$sql2 = " SELECT *, booking.id AS bookingId FROM booking";
$sql2 .= " JOIN room";
$sql2 .= " ON booking.roomId = room.id";
$sql2 .= " JOIN hotel";
$sql2 .= " ON room.hotel_id = hotel.id";
$sql2 .= " WHERE booking.registrationNumber = '" . $registrationNumber . "'";
$sql2 .= " AND booking.checkInDate >= '" . $today . "'";
$sql2 .= " AND booking.status = 'reserved'";
$sql2 .= " ORDER BY checkInDate ASC";
$result2 = $db->query($sql2);

// 今日以前（過去）の予約を取得
$sql3 = "SELECT *, booking.id AS bookingId FROM booking";
$sql3 .= " JOIN room";
$sql3 .= " ON booking.roomId = room.id";
$sql3 .= " JOIN hotel";
$sql3 .= " ON room.hotel_id = hotel.id";
$sql3 .= " WHERE booking.registrationNumber ='" . $registrationNumber . "'";
$sql3 .= " AND booking.checkInDate <'" . $today . "'";
$sql3 .= " AND booking.status = 'reserved'";
$sql3 .= " ORDER BY checkInDate DESC";
$result3 = $db->query($sql3);

// キャンセル済みの記録を取得
$sql4 = "SELECT *, booking.id AS bookingId FROM booking";
$sql4 .= " JOIN room";
$sql4 .= " ON booking.roomId = room.id";
$sql4 .= " JOIN hotel";
$sql4 .= " ON room.hotel_id = hotel.id";
$sql4 .= " WHERE booking.registrationNumber ='" . $registrationNumber . "'";
$sql4 .= " AND booking.status = 'canceled'";
$sql4 .= " ORDER BY checkInDate DESC";
$result4 = $db->query($sql4); 

?>

<main>
<h2>マイページ</h2>
<a href="../index.php">トップページに戻る</a>
<h3>お客様情報</div>
<p>名前: <?= $name ?></p>
<p>生年月日: <?= formatDate($birthday) ?></p>
<p>性別: <?= formatGender($gender) ?></p>
<p>電話番号: <?= $tel ?></p>
<p>メールアドレス: <?= $email ?></p>
<a href="edit.php?registerId=<?= $registrationNumber ?>">会員情報を変更する</a>
<hr>

<h3>現在の予約</h3>
<?php if ($result2->num_rows > 0): ?>
    <?php while($data = $result2->fetch_object()): ?>
        <p>宿泊日:<?= formatDate($data->checkInDate) ?>～<?= formatDate($data->checkOutDate) ?></p>
        <p>宿泊先：<?= $data->hotelName ?></p>
        <button><a href="bookingDetail.php?bookingId=<?= $data->bookingId ?>">予約詳細</a></button>
        <button><a href="cancel.php?bookingId=<?= $data->bookingId ?>">予約をキャンセルする</a></button>
        <br>
        <br>
    <?php endwhile; ?>
<?php else: ?>
    <p>現在予約中のホテルはありません。</p>
<?php endif; ?>

<hr>
<h3>過去の予約履歴</h3>
<?php if ($result3->num_rows > 0): ?>
    <?php while($data = $result3->fetch_object()): ?>
        <p>宿泊日:<?= formatDate($data->checkInDate) ?>～<?= formatDate($data->checkOutDate) ?></p>
        <p>予約番号：<?= $data->bookingId ?></p>
        <button><a href="bookingDetail.php?bookingId=<?= $data->bookingId ?>">予約詳細</a></button>
        
    <?php endwhile; ?>
<?php else: ?>
    <p>過去の予約情報はありません。</p>
    <br>
<?php endif; ?>
<hr>

<h3>キャンセル履歴</h3>
<?php if ($result4->num_rows > 0): ?>
    <?php while($data = $result4->fetch_object()): ?>
        <p>宿泊日:<?= formatDate($data->checkInDate) ?>～<?= formatDate($data->checkOutDate) ?></p>
        <p>予約番号：<?= $data->bookingId ?></p>
        <button><a href="bookingDetail.php?bookingId=<?= $data->bookingId ?>">予約詳細</a></button>
        
    <?php endwhile; ?>
<?php else: ?>
    <p>キャンセル履歴はありません。</p>
    <br>
<?php endif; ?>
</main>
</body>
</html>