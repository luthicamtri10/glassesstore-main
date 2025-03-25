<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('admin.layouts.master')
@section('title', 'Quản lí bảo hành')
@section('content')
<?php

use App\Bus\TaiKhoan_BUS;
use App\Bus\Auth_BUS;
use App\Bus\ChucNang_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Models\TaiKhoan;

    
    $listcn = app(ChucNang_BUS::class)->getAllModels();
    foreach($listcn as $i) {
        echo $i->getTenChucNang() .'<br>';
    }
    
?>

@endsection