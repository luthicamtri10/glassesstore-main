<?php

namespace App\Http\Controllers;

use App\Bus\LoaiSanPham_BUS;
use App\Models\LoaiSanPham;
use Illuminate\Http\Request;

class LoaiSanPhamController extends Controller
{
    private $loaiSanPhamBUS;

    public function __construct(LoaiSanPham_BUS $loaiSanPhamBUS)
    {
        $this->loaiSanPhamBUS = $loaiSanPhamBUS;
    }

    public function store(Request $request){
        $tenLSP = $request->input('tenLSP');
        $moTa = $request->input('moTa');
        
        $loaiSanPham = new LoaiSanPham(null, $tenLSP, $moTa, 1);
        $this->loaiSanPhamBUS->addModel($loaiSanPham);

        return redirect()->back()->with('success', 'Thêm thành công!');
    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
