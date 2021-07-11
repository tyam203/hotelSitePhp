<?php 
require_once('common/common.php');
session_start();
// 日付入力フォームの指定範囲設定用（今日から3日後より選択可能）に$start定義
$start = date('Y-m-d', strtotime('+3 day'));

// prefectureテーブルよりカラムを取得
$sql =  "SELECT * FROM prefecture";
$result = $db->query($sql);

require_once('common/header.php');
?>
<main>
        <?php if(empty($_SESSION['login'])): ?>
            <a href="login.php">ログイン</a>
        <?php else: ?>
            <div><a href="mypage.php">マイページ</a></div>
            <div><a href="logout.php">ログアウト</a></div>
        <?php endif; ?>

    <h2>国内ホテル検索</h2>

    <form method="get" action="searchResult.php" class="form">
        <label>都道府県</label>
        <select name="prefecture">
            <?php while ($data = $result->fetch_object()): ?>
                <option value="<?= $data->id ?>"><?= $data->name ?></option>
            <?php endwhile; ?>
        </select>

        <label>チェックイン</label>
        <input type="date" name="checkInDate" min="<?php echo $start; ?>">

        <label>泊数</label>
        <select name="stayDate">
        <?php makeOptions(1, 5, '泊') ?>
        </select>
        <br>

        <label>部屋数</label>
        <select class="roomNumber" name="roomNumber">
            <option value="0">選択してください</option>
            <?php makeOptions(1, 5, '部屋') ?>
        </select>

        <div class="room room1">
            <div>1部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room1Adult" class="room1Adult">
            <?php makeOptions(1, 5, '名') ?>
            </select>
            
            <label>こども（ベッドあり）</label>
            <select name="room1Child" class="room1Child">
            <?php makeOptions(0, 5, '名') ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room1NoBed" class="room1NoBed">
            <?php makeOptions(0, 5, '名') ?>
            </select>
        </div>
        
        <div class="room room2">
            <div>2部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room2Adult" class="room2Adult">
            <option value="0">選択してください</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドあり）</label>
            <select name="room2Child" class="room2Child">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room2NoBed" class="room2NoBed">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
        </div>
        
        <div class="room room3">
            <div>3部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room3Adult" class="room3Adult">
            <option value="0">選択してください</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドあり）</label>
            <select name="room3Child" class="room3Child">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room3NoBed" class="room3NoBed">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
        </div>
        
        <div class="room room4">
            <div>4部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room4Adult" class="room4Adult">
            <option value="0">選択してください</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドあり）</label>
            <select name="room4Child" class="room4Child">
            <option value="0">0名</option>  
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room4NoBed" class="room4NoBed">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
        </div>
        
        <div class="room room5">
            <div>5部屋目</div>
            <label>大人（12歳以上）</label>
            <select name="room5Adult" class="room5Adult">
            <option value="0">選択してください</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドあり）</label>
            <select name="room5Child" class="room5Child">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
            <label>こども（ベッドなし）</label>
            <select name="room5NoBed" class="room5NoBed">
            <option value="0">0名</option>
            <?php selectNumber() ?>
            </select>
        </div>
        <button type="submit">検索する</button>
    </form>
</main>
<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>