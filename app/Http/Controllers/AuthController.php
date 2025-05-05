<?php
namespace App\Http\Controllers;
use App\Bus\Auth_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Enum\GioiTinhEnum;
use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {
    private Auth_BUS $auth_bus;
    public function __construct(Auth_BUS $auth_bus)
    {   
        $this->auth_bus = $auth_bus;
    }
    public function login($email, $password)
    {
        if($this->auth_bus->login($email, $password)) {
            // return redirect()->back()->with('success','Nguời dùng đăng nhập thành công!');
            return true;
        } else {
            // return redirect()->back()->with('error','Tài khoản đã bị khóa!');
            return false;
        }
        
    }
   
    public function logout() {
        $this->auth_bus->logout();
        return redirect()->back()->with('success','Nguời dùng đăng xuất thành công!');
    } 

    public function register(Request $request) {
        // dd($request->all());
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'ngaySinh' => 'required|date',
            'gioiTinh' => 'required|in:MALE,FEMALE,UNDEFINED',
            'diaChi' => 'required|string|max:255',
            'tinh' => 'required|exists:tinh,id', // hoặc table bạn đang dùng
            'sodienthoai' => 'required|regex:/^[0-9]{10,11}$/',
            'cccd' => 'required|digits:12',
            'tenTK' => 'required|string|min:4|max:30',
            'email' => 'required|email|unique:taikhoan,email', // chỉnh tên bảng nếu khác
            'password' => 'required|string|min:6',
        ]);
        $hoTen = $request->input('hoTen');
        $ngaySinh = $request->input('ngaySinh');
        $gioiTinh = match ($request->input('gioiTinh')) {
            'MALE' => GioiTinhEnum::MALE,
            'FEMALE' => GioiTinhEnum::FEMALE,
            default => GioiTinhEnum::UNDEFINED,
        };
        $diaChi = $request->input('diaChi');
        $tinh = app(Tinh_BUS::class)->getModelById($request->input('tinh'));
        $sdt = $request->input('sodienthoai');
        if (app(NguoiDung_BUS::class)->checkExistingUser($sdt)) {
            return redirect()->back()->with('error', 'Số điện thoại đã tồn tại');
        }
        $cccd = $request->input('cccd');
    
        $nguoidung = new NguoiDung(null, $hoTen, $ngaySinh, $gioiTinh, $diaChi, $tinh, $sdt, $cccd, 1);
        $rs1 = app(NguoiDung_BUS::class)->addModel($nguoidung);
    
        if (!$rs1) {
            return redirect()->back()->with('error', 'Thêm người dùng thất bại!');
        }
    
        $nguoidung = app(NguoiDung_BUS::class)->getModelBySDT($sdt);
        if (!$nguoidung) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng vừa thêm!');
        }
    
        $tentk = $request->input('tenTK'); // sửa tên biến đúng với input
        $email = $request->input('email');
        $password = $request->input('password');
        $quyen = app(Quyen_BUS::class)->getModelById(3);
    
        $account = new TaiKhoan($tentk, $email, $password, $nguoidung, $quyen, 1);
        if(app(TaiKhoan_BUS::class)->checkExistingEmail($account->getEmail())) {
            return redirect()->back()->with('error', 'Email đã tồn tại!');
        } else {
            $rs2 = app(TaiKhoan_BUS::class)->addModel($account);
    
            if (!$rs2) {
                // return response()->json(['success' => false, 'message' => 'Đăng ký thất bại!']);
                return redirect()->back()->with('error', 'Đăng ký thất bại!');
            }
        }
        
    
        // return response()->json(['success' => true, 'message' => 'Đăng ký tài khoản thành công!']);
        return redirect()->back()->with('success', 'Đăng ký tài khoản thành công!');
    }
    
    
}
?>