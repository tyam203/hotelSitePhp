<?php
require_once('simple_html_dom.php');
$html = file_get_html( 'https://pkg.bali-oh.com/detailoil.php?id=17933124&d=202107&dd=1' );
mb_language("Japanese");

$datas = $html->find("#tourcal202107");
foreach($datas as $data) {
    $dates = $data->find("td[class^='f_color']");
    foreach($dates as $date){
        $date = str_replace('&nbsp;', '', $date);
        $date = str_replace('￥', '', $date);
        $date = str_replace(',', '', $date);
    }
}
$file = fopen("scraping.csv", "w");
fputs($file, $date."\n");
fclose($file);
