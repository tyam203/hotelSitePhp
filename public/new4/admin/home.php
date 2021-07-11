<?php 
require_once('../common/common.php');
?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>予約管理画面</title>
	<meta name="description">
	<link rel="stylesheet" href="../css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
	<header>
		<div class="top">
			<h1><a href="index.php">予約管理画面</a></h1>
		</div>
	</header>

    <main>
    <h2>予約記録検索</h2>

    <form method="POST" action="bookingResearch.php">
        <table>
        <tbody>
        <tr>
            <th>予約番号</th>
            <td>
            <input type="text" name="bookingId">
            </td>
        </tr>
        <tr>
            <th>顧客氏名</th>
            <td>
            <input type="text" name="name">
            </td>
        </tr>
        <tr>
            <th>携帯電話番号</th>
            <td>
            <input type="text" name="phoneNumber">
            </td>
        </tr>
        <tr>
            <th>チェックイン日</th>
            <td>
            <input type="text" name="checkInDate">
            </td>
        </tr>
        </tbody>
        </table>
        <button type="submit">検索する</button>

        </form>
</body>
</html>

