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

    <form method="get" action="searchResult1.php" class="form">
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

        <!-- もう少し汎用性を出せないか考える -->
        <?php for($i = 1; $i <= 5; $i++): ?>
            <div class="room room<?= $i ?>">
            <div><?= $i ?>部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room<?= $i ?>Adult" class="room<?= $i ?>Adult">
            <?php makeOptions(0, 5, '名'); ?>
            </select>
            <label>こども（ベッドあり）</label>
            <select name="room<?= $i ?>Child" class="room<?= $i ?>Child">
            <?php makeOptions(0, 5, '名'); ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room<?= $i ?>NoBed" class="room<?= $i ?>NoBed">
            <?php makeOptions(0, 5, '名'); ?>
            </select>
            </div>
        <?php endfor; ?>

        <button type="submit">検索する</button>
    </form>
</main>
<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>