<?php
require_once('../common/common.php');
require_once('../common/header.php');
date_default_timezone_set('Asia/Tokyo');


$date = $_POST['date'];
$nextMonth = date('Y-m-d', strtotime($date . '+1 month'));
$endOfMonth = date('Y-m-d', strtotime($nextMonth . '-1 day'));
$roomId = $_POST['roomId'];
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
    // $sql = " INSERT INTO price3";
    // $sql .= " values(NULL, '$roomId', '$i', '$price');";
    // $result = $db->query($sql);

    $sql2 =" INSERT INTO stock2";
    $sql2 .= " values(NULL, '$i', '20', '$roomId');";
    $result2 = $db->query($sql2);
}
if ($result2 === false) {
    echo $db->error;
} else {
    header('Location: done.php');
    exit;
}
