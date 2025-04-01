<?php

use App\Bus\TaiKhoan_BUS;

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

?>
<!-- <h1>HELLO</h1> -->