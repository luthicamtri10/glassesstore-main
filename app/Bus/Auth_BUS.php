<?php
namespace App\Bus;

use App\Bus\TaiKhoan_BUS;
use App\Utils\JWTUtils; // Import class JWTUtils
session_start();

class Auth_BUS {
    private static $instance;

    public static function getInstance () {
        if (self::$instance == null) {
            self::$instance = new Auth_BUS();
        }
        return self::$instance;
    }

    public function login($email, $password) {
        $user = TaiKhoan_BUS::getInstance()->getModelById($email);
        
        if ($user && password_verify($password, $user->getPassword())) {
            $token = JWTUtils::generateToken($user->getEmail());
            $_SESSION['token'] = $token; // Lưu token vào session
            // echo $token . '<br>';
            return true;
        }
        return false;
    }

    public function isAuthenticated() {
        if (!isset($_SESSION['token'])) {
            return false;
        }
        return JWTUtils::verifyToken($_SESSION['token']) !== null;
    }

    public function logout() {
        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
            return true; // Trả về true khi thành công
        }
        return false; // Trả về false nếu không có token
    }
    
}
?>
