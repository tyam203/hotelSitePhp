<?php
require_once('common/common.php');

$hotelId = $_POST['hotelId'];
$roomId = $_POST['roomId'];
$sql = "SELECT room_type, hotel FROM room WHERE id = $roomId";
$rooms = $db->query($sql);
$room = $rooms->fetch_object();
$roomType = $room->room_type . '/' . $room->hotel;
$date = $_POST['date'];
$nextMonth = date('Y-m-d', strtotime($date . '+1 month'));
$endOfMonth = date('Y-m-d', strtotime($nextMonth . '-1 day'));

$ym = strtotime($date);

$timestamp = strtotime($date . '-01');
$weeks = date('w', $timestamp);
for ($i = $date, $weeks; $i <= $endOfMonth; $i = date('Y-m-d', strtotime($i . '+1 day')), $weeks++){
    $week = $weeks % 7;
    $price = $_POST['price'];
    if($week == 6) {
        $price *= 2;
    }
    elseif($week == 5) {
        $price *= 1.5;
    } elseif($week == 0) {
        $price *= 1.25;
    } else {
        $price = $price;
    }
    $sql = " INSERT INTO price";
    $sql .= " values(NULL,'$hotelId', '$roomId', '$roomType', '$i', '$price');";
    $result = $db->query($sql);
}
if ($result === false) {
    echo $db->error;
} else {
    header('Location: test.php');
    exit;
}
