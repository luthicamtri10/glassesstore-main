<?php

namespace App\Http\Controllers;

use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use Illuminate\Http\Request;
use App\Bus\SanPham_BUS;
use App\Models\SanPham;

class SanPhamController extends Controller
{
    private $sanPhamBUS;
    private $loaiSanPhamBUS;
    private $hangBUS;

    public function __construct(SanPham_BUS $sanPhamBUS, LoaiSanPham_BUS $loaiSanPhamBUS, Hang_BUS $hangBUS)
    {
        $this->sanPhamBUS = $sanPhamBUS;
        $this->loaiSanPhamBUS = $loaiSanPhamBUS;
        $this->hangBUS = $hangBUS;
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $tenSanPham = $request->input('tenSanPham');
        $idHang = $this->hangBUS->getModelById($request->input('idHang'));
        $idLSP = $this->loaiSanPhamBUS->getModelById($request->input('idLSP'));
        $moTa = $request->input('moTa');
        $donGia = $request->input('donGia');
        $thoiGianBaoHanh = $request->input('thoiGianBaoHanh');
        $sanPham = new SanPham(
            null,
            $tenSanPham,
            $idHang,
            $idLSP,
            $moTa,
            $donGia,
            $thoiGianBaoHanh,
            1
        );

        $this->sanPhamBUS->addModel($sanPham);
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công!');
    }

    // Xử lý xóa sản phẩm
    public function destroy($id)
    {
        $this->sanPhamBUS->deleteModel($id);
        return redirect()->route('sanpham.index')->with('success', 'Xóa sản phẩm thành công!');
    }
    public function stock(Request $request) {
        
    } 
}
