<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('admin.layouts.master')
@section('title', 'Quản lí bảo hành')
@section('content')
<?php

use App\Bus\TaiKhoan_BUS;
use App\Bus\Auth_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Models\TaiKhoan;

    
    // $new = new TaiKhoan('tritri', 'lutri222@gmail.com','12345',NguoiDung_BUS::getInstance()->getModelById(1),Quyen_BUS::getInstance()->getModelById(1),1);
    // TaiKhoan_BUS::getInstance()->addModel($new);
    $tk = TaiKhoan_BUS::getInstance()->getModelById("lutri222@gmail.com");
    if($tk != null) {
        echo "YES <br>";
    } else {
        echo "NO <br>";
    }
    if(Auth_BUS::getInstance()->login($tk->getEmail(), '12345')) {
        echo 'SUCCESS!';
    } else {
        echo "FAILED";
    }
    
    echo "Token trong session: " . ($_SESSION['token'] ?? "Không có token!") . "<br>";
    if (isset($_SESSION['token'])) {
        echo "Session token: " . $_SESSION['token'] . "<br>";
    } else {
        echo "⚠️ Không có token trong session! <br>";
    }
    if(Auth_BUS::getInstance()->isAuthenticated()) {
        echo 'SUCCESS LOGIN!';
    } else {
        echo "FAILED LOGIN";
    }
    if(Auth_BUS::getInstance()->logout()) {
        echo 'SUCCESS LOGOUT!';
    } else {
        echo "FAILED LOGOUT";
    }
    
?>

@endsection