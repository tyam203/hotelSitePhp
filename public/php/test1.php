<?php
require_once('common/common.php');

$id = $_POST['id'];
$sql = "SELECT room_type, hotel FROM room WHERE id = $id";
$rooms = $db->query($sql);
$room = $rooms->fetch_object();
$roomType = $room->room_type . '/' . $room->hotel;
$date = $_POST['date'];
$year = mb_substr($date, 0, 4);
$month = mb_substr($date, 5, 2);
$day = mb_substr($date, 8, 2);

$ym = strtotime($date);
$end = date('t', $ym); 

$timestamp = strtotime($date . '-01');
$weeks = date('w', $timestamp);
for ($day, $weeks; $day <= $end; $day++, $weeks++){
    $days = $year . $month . $day;
    echo $days;
    echo '<br>';
    echo '<br>';
}
