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

use function Laravel\Prompts\error;

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
        $gioiTinh = $request->input('gender');
        switch($gioiTinh) {
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
                error("Can not create NGUOIDUNG model");
                break;
        }
        $tinh = $this->tinhBUS->getModelById($request->input('tinh'));
        $sdt = $request->input('sdt');
        $cccd = $request->input('cccd');  
        $nguoidung = new NguoiDung(null, $fullname, $birthdate, $gioiTinh, $address, $tinh, $sdt, $cccd, 1);
        $this->nguoiDungBUS->addModel($nguoidung);
        return redirect()->back()->with('success', 'Nguời dùng đã được thêm thành công!');
    }
    public function update(Request $request) {
        $id = $request->input('id');
        $fullname = $request->input('fullname');
        $birthdate = $request->input('birthdate');
        $address = $request->input('address');  
        $gioiTinh = $request->input('gender');
        switch($gioiTinh) {
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
                error("Can not create NGUOIDUNG model");
                break;
        }
        $tinh = $this->tinhBUS->getModelById($request->input('tinh'));
        $sdt = $request->input('sdt');
        $cccd = $request->input('cccd');  
        $active = $request->input('active');
        $nguoidung = new NguoiDung($id, $fullname, $birthdate, $gioiTinh, $address, $tinh, $sdt, $cccd, $active);
        $this->nguoiDungBUS->updateModel($nguoidung);
        return redirect()->back()->with('success', 'Nguời dùng đã được cập nhật thành công!');
    }
    public function controlDelete(Request $request) {
        $id = $request->input('id');
        $isActive = $this->nguoiDungBUS->getModelById($id)?->getTrangThaiHD();
        $this->nguoiDungBUS->controlDeleteModel($id, $isActive === 1 ? 0 : 1);
        return redirect()->back()->with('success','Nguời dùng cập nhật hoạt động thành công!');
    }
    public function checkExistingUser($sdt) {
        
    }
}

?>