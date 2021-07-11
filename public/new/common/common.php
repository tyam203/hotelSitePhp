<?php

$db = new mysqli("localhost", "root", "mairo0510", "hotel");
$db->query('SET NAMES utf8;');

function formOpen() {
    for($i = 1; $i <= 6; $i++) {
        echo '<option value="' . $i . '">' . $i . '名</option>';
    }   
}

// function travelWithForm() {
//     echo '<dl><dt>氏名</dt>';
//     echo '<dd><input type="text" name="name"></dd>';
//     echo '<dt>生年月日</dt>'; 
//     echo '<dd><input type="date" name="birthday"></dd>';
//     echo '<dt>性別</dt>'; 
//     echo '<dd><input type="radio" name="gender"></dd>';
//     echo '<dd><input type="radio" name="gender"></dd>';
// }
function travelWithForm($i) {
    echo '<dl><dt>氏名</dt>';
    echo '<dd><input type="text" name="name' .  $i . '"></dd>';
    echo '<dt>生年月日</dt>'; 
    echo '<dd><input type="date" name="birthday' .  $i . '"></dd>';
    echo '<dt>性別</dt>'; 
    echo '<dd><input type="radio" value="1" name="gender' .  $i . '">男性</dd>';
    echo '<dd><input type="radio" value="2" name="gender' .  $i . '">女性</dd>';
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
    // elseif ($_POST['gender' . $i] === "1"){
    //     return "男性";
    // } elseif ($_POST['gender' . $i] === "2") {
    //     return "女性";
    // }
}