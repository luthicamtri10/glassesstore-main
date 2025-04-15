<?php
namespace App\Http\Controllers;

use App\Bus\LoaiSanPham_BUS;
use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;

class LoaiSanPhamController extends Controller
{
    private $loaiSanPhamBUS;

    public function __construct(LoaiSanPham_BUS $loaiSanPhamBUS)
    {
        $this->loaiSanPhamBUS = $loaiSanPhamBUS;
    }

    public function index()
    {
        $danhSachLoaiSanPham = $this->loaiSanPhamBUS->getAllModels();
        return view('admin.loaisanpham', compact('danhSachLoaiSanPham'));
    }
}
