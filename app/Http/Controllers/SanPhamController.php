<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus\SanPham_BUS;
use App\Models\SanPham;

class SanPhamController extends Controller
{
    private $sanPhamBUS;

    public function __construct(SanPham_BUS $sanPhamBUS)
    {
        $this->sanPhamBUS = $sanPhamBUS;
    }

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        
        $sanPhams = $this->sanPhamBUS->getAllModels();
        dd($sanPhams); // Kiểm tra dữ liệu
        return view('admin.sanpham', compact('sanPhams'));
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $sanPham = new SanPham(
            null,
            $request->tenSanPham,
            $request->idHang,
            $request->idLSP,
            $request->soLuong,
            $request->moTa,
            $request->donGia,
            $request->thoiGianBaoHanh,
            $request->trangThaiHD
        );

        $this->sanPhamBUS->addModel($sanPham);
        return redirect()->route('sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
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
