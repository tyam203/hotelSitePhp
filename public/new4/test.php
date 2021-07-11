<?php
require_once('common/common.php');
require_once('common/header.php');


$sql = "UPDATE stock2 SET stock = stock - 1";
$sql .= " WHERE stock2.date BETWEEN '2021-06-03' AND '2021-06-04'";
$sql .= " AND stock2.roomId = '1'";
$result = $db->query($sql);
