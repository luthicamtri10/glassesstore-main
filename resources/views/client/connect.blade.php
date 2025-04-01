<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password = "";
$db_name = "glassesstore";

// Kiểm tra mysqli có tồn tại không
if (!class_exists('mysqli')) {
    die("Lỗi: mysqli chưa được kích hoạt!");
}

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}
?>