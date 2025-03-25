<?php

use App\Bus\ChucNang_BUS;

    $tmp = new ChucNang_BUS();
    $c = [];
    $c = $tmp->getAllModels();
    foreach($a as $c) {
        echo $a->id . "<br>";
    }
?>