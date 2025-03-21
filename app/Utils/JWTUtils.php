<?php
namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtils {
    private static $secretKey = "MY_SECRET_KEY";

    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new JWTUtils();
        }
        return self::$instance;
    }

    public static function generateToken($userId) {
        $payload = [
            "iss" => "myapp",
            "iat" => time(),
            "exp" => time() + 3600, // Token hết hạn sau 1 giờ
            "user_id" => $userId
        ];
        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    public static function verifyToken($token) {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (\Exception $e) { // Lưu ý: cần có dấu `\` trước Exception
            return null;
        }
    }
}
?>
