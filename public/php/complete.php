<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>
<h2>予約完了画面</h2>
<h3>以下の内容でご予約が完了しました</h3>
<p>宿泊プラン：<?php echo $_SESSION['roomType']; ?></p>	
<p>宿泊日：<?php echo $_SESSION['checkInDate']; ?></p>	
<p>泊数：<?php echo $_SESSION['stayDate']; ?>泊</p>	
<p>部屋数：<?php echo $_SESSION['roomNumber']; ?>部屋</p>	
<p>大人：<?php echo $_SESSION['totalAdult']; ?>名</p>	
<p>こども(ベッドあり)：<?php echo $_SESSION['totalChild']; ?>名</p>	
<p>こども(ベッドなし)：<?php echo $_SESSION['totalNoBed']; ?>名</p>	
<p>合計金額：<?php echo $_SESSION['totalPrice']; ?>円</p>
<a href="index.php">トップページに戻る</a>