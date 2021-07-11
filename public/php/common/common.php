<?php

$db = new mysqli("localhost", "root", "mairo0510", "hotel");
$db->query('SET NAMES utf8;');

function formOpen() {
    for($i = 1; $i <= 6; $i++) {
        echo '<option value="' . $i . '">' . $i . '名</option>';
    }   
}



