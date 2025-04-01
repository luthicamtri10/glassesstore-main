<?php

use App\Bus\TaiKhoan_BUS;
use App\Bus\ChiTietBaoHanh_BUS;
use App\Models\ChiTietBaoHanh;

// Inject TaiKhoan_BUS if this is in a controller or use app() if still in a view/context
$taiKhoanBus = app(TaiKhoan_BUS::class);
$list = $taiKhoanBus->getAllModels();

if (!empty($list)) {
    echo '<ul>';
    foreach ($list as $i) {
        echo '<li>' . htmlspecialchars($i->getTenTK()) . '</li>'; // Sử dụng htmlspecialchars để tránh XSS
    }
    echo '</ul>';
} else {
    echo '<p>No accounts found.</p>'; // Thông báo nếu không có tài khoản nào
}
$chiTietBHBus = app(ChiTietBaoHanh_BUS::class);
$chiTietBH = new ChiTietBaoHanh(1,1,50000,'1-4-2025','BL001',1);
$bool = $chiTietBHBus->addModel($chiTietBH);
// echo "<p>" . ($bool ? "Thêm chi tiết bảo hành thành công!" : "Thêm chi tiết bảo hành thất bại!") . "</p>";

?>
<!-- <h1>HELLO</h1> -->