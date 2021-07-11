<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();

// 登録情報を取得
$sql = " SELECT * FROM register";
$sql .= " WHERE id='" . $_SESSION['id'] . "'";
$result = $db->query($sql);
$data = $result->fetch_object();
$name = $data->name;
$birthday = $data->birthday;
$gender = $data->gender;
$tel = $data->tel;
$email = $data->email;

$today = date('Y-m-d');
$sql2 = "SELECT * FROM booking";
$sql2 .= " JOIN member";
$sql2 .= " ON booking.id = member.id";
$sql2 .= " JOIN room";
$sql2 .= " ON booking.roomId = room.id";
$sql2 .= " JOIN hotel";
$sql2 .= " ON room.hotel_id = hotel.id";
$sql2 .= " WHERE member.registerId ='" . $_SESSION['id'] . "'";
$sql2 .= " AND booking.checkIn >='" . $today . "'";
$sql2 .= " ORDER BY checkIn ASC";
$result2 = $db->query($sql2);

$sql3 = "SELECT *, booking.id AS bookingId FROM booking";
$sql3 .= " JOIN member";
$sql3 .= " ON booking.id = member.id";
$sql3 .= " JOIN room";
$sql3 .= " ON booking.roomId = room.id";
$sql3 .= " JOIN hotel";
$sql3 .= " ON room.hotel_id = hotel.id";
$sql3 .= " WHERE member.registerId ='" . $_SESSION['id'] . "'";
$sql3 .= " AND booking.checkIn <'" . $today . "'";
$sql3 .= " ORDER BY checkIn DESC";
$result3 = $db->query($sql3); 

?>

<main>
<h2>マイページ</h2>
<h3>お客様情報</h3>
<p>名前:<?= $name ?></p>
<p>生年月日:<?= formatDate($birthday) ?></p>
<p>性別:<?= formatGender($gender) ?></p>
<p>電話番号:<?= $tel ?></p>
<p>メールアドレス:<?= $email ?></p>
<a href="edit.php">会員情報を変更する</a>

<h3>現在の予約</h3>
<?php
if ($result2->num_rows > 0) {
    while($data = $result2->fetch_object()) {
        echo '<p>宿泊日:' . formatDate($data->checkIn) . '～' . formatDate($data->checkOut) . '</p>';
        echo '<p>宿泊先：' . $data->hotelName . '</p>';
        echo '<button><a href="bookingDetail.php">予約詳細</a></button>';
        echo '<button><a href="cancel.php">予約をキャンセルする</a></button>';
    }
} else{
    echo '<p>現在予約中のホテルはありません。</p>';
}
?>
<h3>過去の予約履歴</h3>
<?php
if ($result3->num_rows > 0) {
    while($data = $result3->fetch_object()) {
        echo '<p>宿泊日:' . formatDate($data->checkIn) . '～' . formatDate($data->checkOut) . '</p>';
        echo '<p>予約番号：' . $data->bookingId . '</p>';
        
    }
} else {
    echo '<p>過去の予約情報はありません。</p>';
}
?>
</main>
</body>
</html>