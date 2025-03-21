<?php
namespace App\Dao;

use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Interface\DAOInterface;
use App\Models\TaiKhoan;
use App\Services\database_connection;
use InvalidArgumentException;
use Psy\Readline\Hoa\Console;
use Symfony\Component\Mailer\Event\MessageEvent;

class TaiKhoan_DAO implements DAOInterface {
    private static $instance;
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new TaiKhoan_DAO();
        }
        return self::$instance;
    }
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM TAIKHOAN");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createTaiKhoanModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function createTaiKhoanModel($rs) {
        $tentk = $rs['TENTK'];
        $email = $rs['EMAIL'];
        $password = $rs['PASSWORD'];
        $idNguoiDung = NguoiDung_BUS::getInstance()->getModelById($rs['IDNGUOIDUNG']);
        $idQuyen = Quyen_BUS::getInstance()->getModelById($rs['IDQUYEN']);
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new TaiKhoan($tentk, $email, $password, $idNguoiDung, $idQuyen, $trangThaiHD);
    }
    public function getAll() : array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM TAIKHOAN");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createTaiKhoanModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM TAIKHOAN WHERE email = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createTaiKhoanModel($row);
            }
        }
        return null;
    }
    public function insert($model): int {
        $query = "INSERT INTO TAIKHOAN (tentk, email, password, idNguoiDung, idQuyen, trangthaihd) VALUES (?,?,?,?,?,?)";
        $args = [$model->getTenTK(),$model->getEmail(), password_hash($model->getPassword(), PASSWORD_DEFAULT), $model->getIdNguoiDung()->getId(), $model->getIdQuyen()->getId(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }
    public function update($model): int {
        $query = "UPDATE TAIKHOAN SET tentk = ?, password = ?, idnguoidung = ?, idquyen = ?, trangThaiHD = ? WHERE email = ?";
        $args = [$model->getTenTK(), password_hash($model->getPassword(), PASSWORD_DEFAULT), $model->getIdNguoiDung()->getId(), $model->getIdQuyen()->getId(), $model->getTrangThaiHD(), $model->getEmail()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;  
    }
    public function delete($email): int
    {
        $query = "UPDATE TAIKHOAN SET trangThaiHD = false WHERE email = ?";
        $result = database_connection::executeUpdate($query, ...[$email]);
        
        return is_int($result) ? $result : 0;
    }

    public function search(string $condition, $columnNames): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM TAIKHOAN WHERE TENTK LIKE ? OR EMAIL LIKE ? OR PASSWORD LIKE ? OR IDNGUOIDUNG LIKE ? OR IDQUYEN LIKE ? OR trangThaiHD LIKE ? ";
            $args = array_fill(0,  6, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM TAIKHOAN WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM TAIKHOAN WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createTaiKhoanModel($row);
            array_push($list, $model);
        }
        if (count($list) === 0) {
            return [];
        }
        return $list;
    }

    public function checkLogin($email, $password): bool {
        $query = "SELECT password FROM TAIKHOAN WHERE email = ?";
        $result = database_connection::executeQuery($query, $email);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // var_dump($row); // Xem kết quả có đúng không
            
            $hashedPassword = $row['password'];
            if (password_verify($password, $hashedPassword)) {
                return true;
            }
        }
        return false;
    }
    
    public function login($email, $password) {
        session_start();
        
        $taiKhoanDAO = TaiKhoan_DAO::getInstance();
        $user = $taiKhoanDAO->getById($email);
    
        if (!$user) {
            return "Email không tồn tại!";
        }
    
        if (!password_verify($password, $user->getPassword())) {
            return "Mật khẩu không đúng!";
        }
    
        // Đăng nhập thành công
        $_SESSION['user'] = $user->getEmail();
        return "Đăng nhập thành công!";
    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php"); // Chuyển hướng về trang đăng nhập
        exit();
    }
       
}   
?>