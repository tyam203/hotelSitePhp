<?php 
require_once('common/common.php');

// 日付入力フォームの指定範囲設定用（今日から3日後より選択可能）に$start定義
$start = date('Y-m-d', strtotime('+3 day'));

// prefectureテーブルよりカラムを取得
$sql =  "SELECT prefectureId, prefectureName FROM hotel";
$sql .= " GROUP BY prefectureId";
$result = $db->query($sql);
require_once('common/header.php');
?>
<main>
        <?php if(empty($_SESSION['login'])): ?>
            <a href="info/login.php">ログイン</a>
        <?php else: ?>
            <div><a href="info/mypage.php">マイページ</a></div>
            <div><a href="info/logout.php">ログアウト</a></div>
        <?php endif; ?>

    <h2>国内ホテル検索</h2>

    <form method="get" action="searchResult.php" class="form">
        <label>都道府県</label>
        <select name="prefecture">
            <?php while ($data = $result->fetch_object()): ?>
                <option value="<?= $data->prefectureId ?>"><?= $data->prefectureName ?></option>
            <?php endwhile; ?>
        </select>

        <label>チェックイン</label>
        <input type="date" name="checkInDate" min="<?php echo $start; ?>">

        <label>泊数</label>
        <select name="stayCount">
        <?php makeOptions(1, 5, '泊') ?>
        </select>
        <br>

        <label>部屋数</label>
        <select class="roomNumber" name="roomNumber">
            <option value="0">選択してください</option>
            <?php makeOptions(1, 5, '部屋') ?>
        </select>


        <?php makeForms(1, 5) ?>
        
        

        <button type="submit">検索する</button>
    </form>
</main>
<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>