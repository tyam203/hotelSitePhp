<?php

$db = new mysqli("localhost", "root", "mairo0510", "hotel2");
$db->query('SET NAMES utf8;');

session_start();

// 泊数選択
// function selectStay() {
//     for($i = 1; $i <= 6; $i++) {    
//         echo '<option value="' . $i . '">' . $i . '泊</option>';
//     }   
// }

// 選択肢作成
function makeOptions($min, $max, $unit) {
    for($i = $min; $i <= $max; $i++) {
        echo '<option value="' . $i . '">' . $i . $unit . '</option>';
    }   
}

// 部屋数に応じてルーミングのフォーム表示
// もう少し汎用性を出せないか考える
function makeForms($min, $max){
    for($j = $min; $j <= $max; $j++){
        echo '<div class="room room' . $j . '">';
        echo '<div>' . $j . '部屋目</div>';

        echo '<label>大人(12歳以上)</label>';
        echo '<select name="room' .  $j . 'Adult" class="room' . $j . 'Adult">';
        makeOptions(0, 5, '名');
        echo '</select>';

        echo '<label>こども(ベッドあり)</label>';
        echo '<select name="room' .  $j . 'Child" class="room' . $j . 'Child">';
        makeOptions(0, 5, '名');
        echo '</select>';

        echo '<label>こども(ベッドなし)</label>';
        echo '<select name="room' .  $j . 'NoBed" class="room' . $j . 'NoBed">';
        makeOptions(0, 5, '名');
        echo '</select>';
        echo '</div>';
    }
}
// 人数選択
// function selectNumber() {
//     for($i = 1; $i <= 6; $i++) {
//         echo '<option value="' . $i . '">' . $i . '名</option>';
//     }   
// }
// 同行者情報入力フォーム表示
function travelWithForm($i) {
    echo '<dl><dt>氏名</dt>';
    echo '<dd><input type="text" name="name' .  $i . '"></dd>';
    echo '<dt>生年月日</dt>'; 
    echo '<dd><input type="date" name="birthday' .  $i . '"></dd>';
    echo '<dt>性別</dt>'; 
    echo '<dd><input type="radio" value="1" name="gender' .  $i . '">男性</dd>';
    echo '<dd><input type="radio" value="2" name="gender' .  $i . '">女性</dd>';
}

// 日付フォーマット変更
function formatDate($date) {
    return date('Y年n月j日', strtotime($date));
}

// 性別文字化ツール
function formatGender($gender) {
    if ($gender === "1") {
        return "男性";
    } else {
        return "女性";
    }

}

// 年齢計算ツール
function ageCalculate($birthday) {
    $now = date("Ymd");
    $birthday = str_replace("-", "", $birthday);
    return floor(($now-$birthday)/10000).'歳';
}

// 性別文字化ツール
function genderCheck($gender) {
    if ($_POST['gender'] === "1"){
        return "男性";
    } elseif ($_POST['gender'] === "2") {
        return "女性";
    } 
}