<?php

$developer = 'Тело, преобразующее пиццу и кофе в код, преимущественно после полуночи.';
$coffee = 'Если программист устал - пей кофе';
$google_help = 'Если ничего не получается - лезь в Гугл/Хабр';
$stupid_seo = 'Поори на сео-оптимизатора, если он поковырял cms-ку';
$stupid_designer = 'Поори на дизайнера, если хреновая сетка и куча анимации';
$developer_ideal_day = $coffee . $google_help . $stupid_seo . $stupid_designer;
echo date('d/m');
echo $developer_ideal_day;
if (date('d/m') == '23/02') {
    echo 'Да прибудет с тобой сила 0 и 1, чтобы клава с мышью была как меч джедая';
}
