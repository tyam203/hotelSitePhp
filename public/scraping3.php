<?php

require_once 'simple_html_dom.php';

$dom = new simple_html_dom();

$dom->load_file('https://pkg.bali-oh.com/detailoil.php?id=17933124&d=202107&dd=1');

$prices = $dom->find('#tourcal202107');

$result = $prices[0]->plaintext;
print_r($result);die;

$dayAndPrice = explode(' ', $result);
foreach ($dayAndPrice as $key => $value){
    if($key <= 23) continue;
    if(trim($value) === '') continue;
    $explode[] = explode('￥', $value);
}
print_r($explode);

// $fp = fopen('simplehtmldom.csv', 'w');

// if($fp){
//     foreach ($explode as $line){
//         fputcsv($fp, $line);
//     }
// }

// fclose($fp);