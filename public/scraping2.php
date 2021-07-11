<?php
require_once('simple_html_dom.php');

$html = file_get_html( 'https://pkg.bali-oh.com/detailoil.php?id=17933124&d=202107&dd=1' );

foreach ($html->find('#tourcal202107 td') as $dayAndPrice) {
    $dayAndPriceArray = explode("￥", $dayAndPrice->plainText);
    $arry[] = $dayAndPriceArray;
}

$fp = fopen("scraping.csv", "w");

if ($fp) {
    foreach ($arry as $line) {
        fputcsv($fp, $line);
    }
}

