<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\NguoiDung;

class NguoiDungController extends Controller
{
    protected $tinhBUS;
    protected $nguoiDungBUS;

    public function __construct(Tinh_BUS $tinh_bus, NguoiDung_BUS $nguoi_dung_bus)
    {
        $this->tinhBUS = $tinh_bus;
        $this->nguoiDungBUS = $nguoi_dung_bus;
    }

    public function store(Request $request)
    {
        $fullname = $request->input('fullname');
        $birthdate = $request->input('birthdate');
        $address = $request->input('address');  
        $gioiTinhInput = $request->input('gender');

        switch($gioiTinhInput) {
            case 'MALE':
                $gioiTinh = GioiTinhEnum::MALE;
                break;
            case 'FEMALE':
                $gioiTinh = GioiTinhEnum::FEMALE;
                break;
            case 'UNDEFINED':
                $gioiTinh = GioiTinhEnum::UNDEFINED;
                break;
            default:
                return redirect()->back()->with('error', 'Giới tính không hợp lệ');
        }

        $tinh = $this->tinhBUS->getModelById($request->input('tinh'));
        $sdt = $request->input('sdt');
        $cccd = $request->input('cccd');  

        $nguoidung = new NguoiDung(null, $fullname, $birthdate, $gioiTinh, $address, $tinh, $sdt, $cccd, 1);
        $this->nguoiDungBUS->addModel($nguoidung);

        return redirect()->back()->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $hoten = $request->input('HOTEN');
        $ngaysinh = $request->input('NGAYSINH');
        $gioitinhInput = $request->input('GIOITINH');

        switch($gioitinhInput) {
            case 'MALE':
                $gioitinh = GioiTinhEnum::MALE;
                break;
            case 'FEMALE':
                $gioitinh = GioiTinhEnum::FEMALE;
                break;
            case 'UNDEFINED':
                $gioitinh = GioiTinhEnum::UNDEFINED;
                break;
            default:
                return redirect()->back()->with('error', 'Giới tính không hợp lệ');
        }

        $diachi = $request->input('DIACHI');
        $tinh = $this->tinhBUS->getModelById($request->input('IDTINH'));
        $sdt = $request->input('SODIENTHOAI');
        $cccd = $request->input('CCCD');
        $trangthaihd = $request->input('TRANGTHAIHD');

        $nguoidung = new NguoiDung($id, $hoten, $ngaysinh, $gioitinh, $diachi, $tinh, $sdt, $cccd, $trangthaihd);
        $result = $this->nguoiDungBUS->updateModel($nguoidung);
        
        if (!$result) {
            return redirect()->back()->with('error', 'Cập nhật người dùng thất bại');
        }

        return redirect()->back()->with('success', 'Người dùng đã được cập nhật thành công!');
    }

    public function controlDelete(Request $request)
    {
        $id = $request->input('id');
        $isActive = $this->nguoiDungBUS->getModelById($id)?->getTrangThaiHD();
        $this->nguoiDungBUS->controlDeleteModel($id, $isActive === 1 ? 0 : 1);
        return redirect()->back()->with('success','Người dùng cập nhật hoạt động thành công!');
    }

    public function checkExistingUser($sdt)
    {
        // Placeholder for checking if user exists
    }

    public function updateInfo(Request $request)
    {
        $id = $request->input('id');
        $hoten = $request->input('hoTen');
        $sdt = $request->input('soDienThoai');
        $diachi = $request->input('diaChi');
        
        // Get existing user to preserve other fields
        $existingUser = $this->nguoiDungBUS->getModelById($id);
        if (!$existingUser) {
            return redirect()->back()->with('error', 'Không tìm thấy người dùng');
        }

        // Convert string gender to enum
        $gioiTinhStr = $existingUser->getGioiTinh();
        $gioiTinh = match ($gioiTinhStr) {
            'MALE' => GioiTinhEnum::MALE,
            'FEMALE' => GioiTinhEnum::FEMALE,
            default => GioiTinhEnum::UNDEFINED,
        };

        // Create new user object with updated fields
        $nguoidung = new NguoiDung(
            $id,
            $hoten,
            $existingUser->getNgaySinh(),
            $gioiTinh,
            $diachi,
            $existingUser->getTinh(),
            $sdt,
            $existingUser->getCccd(),
            $existingUser->getTrangThaiHD()
        );

        $result = $this->nguoiDungBUS->updateModel($nguoidung);
        
        if (!$result) {
            return redirect()->back()->with('error', 'Cập nhật thông tin thất bại');
        }   
       
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}

?>
