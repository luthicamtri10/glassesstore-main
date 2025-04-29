<?php

namespace App\Http\Controllers;

use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use Illuminate\Http\Request;
use App\Bus\SanPham_BUS;
use App\Models\SanPham;
use Intervention\Image\ImageManager;






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

        $anhSanPham = $request->file('anhSanPham');

        // Tạo sản phẩm mới
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

        // Thêm sản phẩm vào database và lấy ID mới
        $newSanPham = $this->sanPhamBUS->addModel($sanPham);

        // Nếu có ảnh, di chuyển ảnh vào thư mục lưu trữ
        if ($anhSanPham) {
            $tenAnh = $newSanPham . '.' . $anhSanPham->getClientOriginalExtension();
            $anhSanPham->move(public_path('productImg'), $tenAnh); // Di chuyển ảnh
        } 
        // else {
        //     dd('Không có file ảnh nào được gửi');
        // }

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request) {
        $idSanPham = $request->input('idSanPham');
        $tenSanPham = $request->input('tenSanPham');
        $idHang = $this->hangBUS->getModelById($request->input('idHang'));
        $idLSP = $this->loaiSanPhamBUS->getModelById($request->input('idLSP'));
        $moTa = $request->input('moTa');
        $donGia = $request->input('donGia');
        $thoiGianBaoHanh = $request->input('thoiGianBaoHanh');

        $anhSanPham = $request->file('anhSanPham');

        // Tạo sản phẩm mới
        $sanPham = new SanPham(
            $idSanPham,
            $tenSanPham,
            $idHang,
            $idLSP,
            $moTa,
            $donGia,
            $thoiGianBaoHanh,
            1
        );

        // Thêm sản phẩm vào database và lấy ID mới
        $newSanPham = $this->sanPhamBUS->updateModel($sanPham);

        // Xử lý file ảnh nếu có gửi lên
        if ($anhSanPham) {
            $tenAnh = $newSanPham . '.' . $anhSanPham->getClientOriginalExtension();
            $anhSanPham->move(public_path('productImg'), $tenAnh);
        }
        return redirect()->back()->with('success', 'Cập nhật thành công!');
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
