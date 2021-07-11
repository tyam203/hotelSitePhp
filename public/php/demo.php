<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();

$sql = " SELECT * FROM room";
$sql .= " JOIN price";
// 部屋idが一致するもののみを結合。すなわちすべて結合
$sql .= " ON room.id = price.roomId";
$sql .= " JOIN hotel";
// ホテルidが一致するもののみを結合。すなわちすべて
$sql .= " ON room.hotel_id = hotel.id";
$sql .= " WHERE room.id = 1";
$sql .= " AND price.date = '2021-05-22'";

$result = $db->query($sql);
if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        var_dump($data);
        echo '<br>';
    }
}
        
