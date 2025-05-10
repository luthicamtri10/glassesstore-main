<?php

namespace App\Http\Controllers;

use App\Bus\CTHD_BUS;
use App\Bus\Hang_BUS;
use App\Bus\KieuDang_BUS;
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
    private $kieuDangBUS;

    public function __construct(SanPham_BUS $sanPhamBUS, LoaiSanPham_BUS $loaiSanPhamBUS, Hang_BUS $hangBUS, KieuDang_BUS $kieuDangBUS)
    {
        $this->sanPhamBUS = $sanPhamBUS;
        $this->loaiSanPhamBUS = $loaiSanPhamBUS;
        $this->hangBUS = $hangBUS;
        $this->kieuDangBUS = $kieuDangBUS;
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tenSanPham' => 'required|string|max:255',
            'moTa' => 'required|string',
            'thoiGianBaoHanh' => 'required|integer',
            'anhSanPham' => 'required|image|mimes:webp|max:2048',
        ], [
            'tenSanPham.required' => 'Vui lòng nhập tên sản phẩm.',
            'moTa.required' => 'Vui lòng nhập mô tả.',
            'thoiGianBaoHanh.required' => 'Vui lòng nhập thời gian.',
            'thoiGianBaoHanh.integer' => 'Phải là số.',
            'anhSanPham.required' => 'Vui lòng chọn ảnh.',
            'anhSanPham.image' => 'Ảnh sản phẩm không hợp lệ.',
            'anhSanPham.mimes' => 'Ảnh sản phẩm phải có định dạng webp.',
            'anhSanPham.max' => 'Ảnh sản phẩm không được lớn hơn 2MB.',
        ]);

        $tenSanPham = $validatedData['tenSanPham'];
        $idHang = $this->hangBUS->getModelById($request->input('idHang'));
        $idLSP = $this->loaiSanPhamBUS->getModelById($request->input('idLSP'));
        $idKieuDang = $this->kieuDangBUS->getModelById($request->input('idKieuDang'));
        $moTa = $validatedData['moTa'];
        // $donGia = $request->input('donGia');
        $thoiGianBaoHanh = $validatedData['thoiGianBaoHanh'];

        $anhSanPham = $request->file('anhSanPham');
        // dd($request->all());
        // Tạo sản phẩm mới
        $sanPham = new SanPham(
            null,
            $tenSanPham,
            $idHang,
            $idLSP,
            $idKieuDang,
            $moTa,
            null,
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

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request) {
        $idSanPham = $request->input('idSanPham');
        $tenSanPham = $request->input('tenSanPham');
        $idHang = $this->hangBUS->getModelById($request->input('idHang'));
        $idLSP = $this->loaiSanPhamBUS->getModelById($request->input('idLSP'));
        $idKieuDang = $this->kieuDangBUS->getModelById($request->input('idKieuDang'));
        $moTa = $request->input('moTa');
        $thoiGianBaoHanh = $request->input('thoiGianBaoHanh');

        $anhSanPham = $request->file('anhSanPham');

        // Tạo sản phẩm mới
        $sanPham = new SanPham(
            $idSanPham,
            $tenSanPham,
            $idHang,
            $idLSP,
            $idKieuDang,
            $moTa,
            null,
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
