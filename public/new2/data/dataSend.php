<?php
require_once('../common/common.php');
// require_once('../common/header.php');
date_default_timezone_set('Asia/Tokyo');

?>


<form action="" method="post">


<select name="id">
<?php
$sql = "SELECT * FROM hotel2 GROUP BY hotelName";
$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<option value="' . $data->id . '">' . $data->hotelName . '</option>';
}
?>
</select>
<input type="submit" value="次の選択項目へ">
</form>



<form action="insert.php" method="post">

<select name="hotelId">
<?php
$sql = "SELECT * FROM hotel2";
// $sql = "SELECT * FROM hotel2 GROUP BY hotelName";
$sql .= " WHERE id ='" . $_POST['id'] . "'";
$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<option value="' . $data->id . '">' . $data->hotelName . '</option>';
}
?>
</select>

<select name="roomId">
<?php
$sql2 = "SELECT * FROM room2";
$sql2 .= " WHERE room2.hotel_id ='" . $_POST['id'] . "'";
$result2 = $db->query($sql2);
while ($data2 = $result2->fetch_object()) {
    echo '<option value="' . $data2->id . '">' . $data2->room_type . '</option>';
}
?>
</select>
<input type="date" name="date">
<input type="number" name="price">
<input type="submit" value="送信する">
</form>



<!-- <?= $_POST['hotelId'] ?> -->

</body>
</html>




