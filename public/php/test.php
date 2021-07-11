<?php
require_once('common/common.php');
require_once('common/header.php');
date_default_timezone_set('Asia/Tokyo');

?>


<form action="test2.php" method="post">


<select name="hotelId">
<?php
$sql = "SELECT * FROM room GROUP BY hotel";
$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<option value="' . $data->hotel_id . '">' . $data->hotel . '</option>';
}
?>
</select>

<select name="roomId">
<?php
$sql = "SELECT * FROM room";
$result = $db->query($sql);
while ($data = $result->fetch_object()) {
    echo '<option value="' . $data->id . '">' . $data->room_type . ' / ' . $data->hotel . '</option>';
}
?>
</select>
<input type="date" name="date">
<input type="number" name="price">
<input type="submit" value="実行する">
</form>

<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>



