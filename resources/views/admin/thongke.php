<?php

use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Dao\Tinh_DAO;
use App\Enum\GioiTinhEnum;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\TaiKhoan;

    $tk_list = TaiKhoan_BUS::getInstance()->getAllModels();
    $newTK = new TaiKhoan("ltri", "trilu@gmail.com", "12345", NguoiDung_BUS::getInstance()->getModelById(2), Quyen_BUS::getInstance()->getModelById(3), 1);
    echo TaiKhoan_BUS::getInstance()->login("trilu@gmail.com", "12345") . '<br>';
    echo 'user: ' . $_SESSION['user'] . '<br>';

    if (TaiKhoan_BUS::getInstance()->checkLogin("trilu@gmail.com", "12345") === true) {
        echo 'SUCCESS: ';
    } else {
        echo "FAILED";
    }

    echo '<br>' . TaiKhoan_BUS::getInstance()->checkLogin("trilu@gmail.com", "12345");
 ?>