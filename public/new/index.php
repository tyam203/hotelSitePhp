<?php 
require_once('common/common.php');
session_start();
session_destroy();

// 日付入力フォームの指定範囲設定用（今日から3日後より選択可能）に$start定義
$start = date('Y-m-d', strtotime(date('Y-m-d') . '+3 day'));

// prefectureテーブルよりカラムを取得
$sql =  "SELECT * FROM prefecture";
$result = $db->query($sql);

require_once('common/header.php');
?>
<main>
    <h1>国内ホテル検索</h1>
    <form method="get" action="searchResult.php" class="form">
    <!-- <form method="get" action="searchResult.php" class="form"> -->
        <label>都道府県</label>
        <select name="prefecture">
            <?php while ($data = $result->fetch_object()): ?>
                <option value="<?= $data->id ?>"><?= $data->name ?></option>
            <?php endwhile; ?>
        </select>
        <br>

        <label>チェックイン</label>
        <input type="date" name="checkInDate" min="<?php echo $start; ?>">
        <br>

            <label>泊数</label>
        <select name="stayDate">
            <?php
            for($i = 1; $i <= 6; $i++) {
                echo '<option value="' . $i . '">' . $i . '泊</option>';
            }
            ?>
        </select>
        <br>

        <label>部屋数</label>
        <select class="roomNumber" name="roomNumber">
            <option value="0">選択してください</option>
            <?php
            for($i = 1; $i <= 5; $i++) {
                echo '<option value="' . $i . '">' . $i . '部屋</option>';
            }
            ?>
        </select>

        <div class="room room1">
            <div>1部屋目
                <br>
                <label>大人（12歳以上）
                <select name="room1Adult" class="room1Adult">
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドあり）
                <select name="room1Child" class="room1Child">
                <option value="0">0名</option>
                <?php formOpen(); ?>
                </select>
                <br>
                <label>こども（ベッドなし）
                <select name="room1NoBed" class="room1NoBed">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
            </div>
        </div>
        
        <div class="room room2">
            <div>2部屋目
                <br>
                <label>大人（12歳以上）
                <select name="room2Adult" class="room2Adult">
                <option value="0">選択してください</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドあり）
                <select name="room2Child" class="room2Child">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドなし）
                <select name="room2NoBed" class="room2NoBed">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
            </div>
        </div>
        
        <div class="room room3">
            <div>3部屋目
                <br>
                <label>大人（12歳以上）
                <select name="room3Adult" class="room3Adult">
                <option value="0">選択してください</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドあり）
                <select name="room3Child" class="room3Child">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドなし）
                <select name="room3NoBed" class="room3NoBed">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
            </div>
        </div>
        
        <div class="room room4">
            <div>4部屋目
                <br>
                <label>大人（12歳以上）
                <select name="room4Adult" class="room4Adult">
                <option value="0">選択してください</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドあり）
                <select name="room4Child" class="room4Child">
                <option value="0">0名</option>  
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドなし）
                <select name="room4NoBed" class="room4NoBed">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
            </div>
        </div>
        
        <div class="room room5">
            <div>5部屋目
                <br>
                <label>大人（12歳以上）
                <select name="room5Adult" class="room5Adult">
                <option value="0">選択してください</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドあり）
                <select name="room5Child" class="room5Child">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
                <br>
                <label>こども（ベッドなし）
                <select name="room5NoBed" class="room5NoBed">
                <option value="0">0名</option>
                <?php
                formOpen();
                ?>
                </select>
            </div>
        </div>
        <button type="submit">検索する</button>
    </form>
</main>
<script type="text/javascript" src="js/hotel.js"></script>
</body>
</header>