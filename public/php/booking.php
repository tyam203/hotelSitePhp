<?php
require_once('common/common.php');
require_once('common/header.php');
session_start();
?>
<h2>お客様情報入力画面</h2>	
<form method="POST" action="complete.php" class="customerForm">	
<div>代表者氏名：	
<input type="text" class="name">	
</div>	
		
<div>電話番号：	
<input type="tel" class="phone">	
</div>	
		
<div>メールアドレス：	
<input type="email" class="email">	
</div>	
<div>備考欄:
    <textarea placeholder="(例)高層階希望など"></textarea>
</div>	
<button type="submit">予約完了へ</button>	
</form>	

<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>
