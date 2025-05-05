<?php

namespace App\Http\Controllers;

use App\Bus\CTHD_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use Illuminate\Http\Request;
use App\Bus\SanPham_BUS;
use App\Models\SanPham;
use Intervention\Image\ImageManager;

use function Laravel\Prompts\alert;

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
        $trangThai = $request->input('trangThai');

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
            $trangThai
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
    public function delete(Request $request)
    {
        // dd($request->all());
        $id = $request->input('product_id');
        if(app(CTHD_BUS::class)->checkSPIsSold($id)) {
            app(SanPham_BUS::class)->controlActive($id);
            return redirect()->back()->with('success','Cập nhật trạng thái sản phẩm thành công!');
        } else {
            app(SanPham_BUS::class)->deleteModel($id);
            // alert('Sản phẩm đã được bán, không thể xóa!');
            return redirect()->back()->with('success','Xóa sản phẩm thành công!');
        }
        return redirect()->back()->with('error','Xóa sản phẩm thất bại!');
    }
    public function checkIsSold(Request $request)
    {
        // dd($request->all());
        $productId = $request->input('product_id');
        
        $sanpham = app(SanPham_BUS::class)->getModelById($productId);
        // dd($sanpham);
        $isSold = app(CTHD_BUS::class)->checkSPIsSold($sanpham->getId()); 
        if($isSold) {
            app(SanPham_BUS::class)->controlActive($productId);
            return redirect()->back()->with('success','Cập nhật trạng thái sản phẩm thành công!');
        } else {
            // return redirect()->back()->with('error','Sản phẩm chưa được bán không được xóa!');
            return redirect()->back()->with('confirm_delete', $productId);
        }
    }
    // public function delete(Request $request) {
    //     $id = $request->input('id');
    //     app(SanPham_BUS::class)->deleteModel($id);
    //     return redirect()->back()->with('success','Xóa sản phẩm thành công!');
    // }
    // public function controlActive(Request $request) {
    //     $id = $request->input('id');
    //     app(SanPham_BUS::class)->controlActive($id);
    //     return redirect()->back()->with('success','Cập nhật trạng thái sản phẩm thành công!');
    // }
    
}
