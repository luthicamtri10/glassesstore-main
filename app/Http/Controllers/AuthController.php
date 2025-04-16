<?php
namespace App\Http\Controllers;
use App\Bus\Auth_BUS;
use App\Bus\NguoiDung_BUS;
use App\Http\Controllers\Controller;

class AuthController extends Controller {
    private Auth_BUS $auth_bus;
    public function __construct(Auth_BUS $auth_bus)
    {   
        $this->auth_bus = $auth_bus;
    }
    public function login($email, $password)
    {
        $this->auth_bus->login($email, $password);
        return redirect()->back()->with('success','Nguời dùng đăng nhập thành công!');
    }
    public function register($account) {

    }
    public function logout() {
        $this->auth_bus->logout();
        return redirect()->back()->with('success','Nguời dùng đăng xuất thành công!');
    }
    // public function checkPhoneNumber($sdt) {
    //     if(app(NguoiDung_BUS::class)->checkExistingUser($sdt)) {
    //         return redirect()
    //     }
    // }
    
}
?>