<?php
namespace App\Dao;
use App\Bus\NguoiDung_BUS;
use App\Bus\SanPham_BUS;
use App\Interface\DAOInterface;
use App\Models\GioHang;
use App\Services\database_connection;
use InvalidArgumentException;

class GioHang_DAO implements DAOInterface
{
    /**
     * Đọc toàn bộ dữ liệu từ bảng GIOHANG
     */
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM giohang");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createGioHangModel($row);
            $list[] = $model;
        }
        return $list;
    }

    /**
     * Tạo mô hình GioHang từ dữ liệu cơ sở dữ liệu
     */
    private function createGioHangModel(array $rs): GioHang
    {
       $email = app(NguoiDung_BUS::class)->getModelById($rs['email']);
       $idSanPham = app(SanPham_BUS::class)->getModelById($rs['idSanPham']);
       $soSeri = $rs['soSeri'];
       return new GioHang($email,$idSanPham,$soSeri);
    }

    /**
     * Lấy tất cả bản ghi từ bảng GIOHANG
     */
    public function getAll(): array
    {
        return $this->readDatabase();
    }

    /**
     * Lấy một bản ghi theo email và soSeri (giả sử đây là khóa chính)
     */
    public function getById($id): ?GioHang
    {
        // Giả sử $id là một mảng chứa email và soSeri
        if (!is_array($id) || !isset($id['email']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và soSeri");
        }

        $query = "SELECT * FROM giohang WHERE EMAIL = ? AND SOSERI = ?";
        $result = database_connection::executeQuery($query, $id['email'], $id['soSeri']);
        
        if ($result->num_rows > 0) {
            return $this->createGioHangModel($result->fetch_assoc());
        }
        return null;
    }
    private function emailExists(string $email): bool
    {
        $query = "SELECT COUNT(*) as count FROM taikhoan WHERE EMAIL = ?";
        $rs = database_connection::executeQuery($query, $email);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    /**
     * Kiểm tra sự tồn tại của idNhanVien trong bảng nguoidung
     */
    private function productExists(int $idSanPham): bool
    {
        $query = "SELECT COUNT(*) as count FROM sanpham WHERE ID = ?";
        $rs = database_connection::executeQuery($query, $idSanPham);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }
    private function soSeriExists(int $idSanPham,string $soSeri): bool
    {
        $query = "SELECT COUNT(*) as count FROM ctsp WHERE IDSP = ? AND SOSERI = ?";
        $rs = database_connection::executeQuery($query, $idSanPham, $soSeri);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    /**
     * 
     * Thêm một bản ghi vào bảng GIOHANG
     */
    public function insert($e): int
    {
        if (!$e instanceof GioHang) {
            throw new InvalidArgumentException("Tham số phải là instance của GioHang");
        }
        // Kiểm tra khóa ngoại
        if (!$this->emailExists($e->getEmail())) {
            throw new \Exception("Email {$e->getEmail()} không tồn tại trong bảng taikhoan.");
        }
        if (!$this->productExists($e->getIdSanPham())) {
            throw new \Exception("ID sanpham {$e->getIdSanPham()} không tồn tại trong bảng sanpham.");
        }
        if (!$this->soSeriExists($e->getIdSanPham(),$e->getSoSeri())) {
            throw new \Exception("So Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }

        $query = "INSERT INTO GIOHANG (email, idSanPham, soSeri) VALUES (?, ?, ?)";
        $args = [$e->getEmail(), $e->getIdSanPham(), $e->getSoSeri()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Cập nhật một bản ghi trong bảng GIOHANG
     */
    public function update($e): int
    {
        if (!$e instanceof GioHang) {
            throw new InvalidArgumentException("Tham số phải là instance của GioHang");
        }
        // Kiểm tra khóa ngoại
        if (!$this->emailExists($e->getEmail())) {
            throw new \Exception("Email {$e->getEmail()} không tồn tại trong bảng taikhoan.");
        }
        if (!$this->productExists($e->getIdSanPham())) {
            throw new \Exception("ID sanpham {$e->getIdSanPham()} không tồn tại trong bảng sanpham.");
        }
        if (!$this->soSeriExists($e->getIdSanPham(),$e->getSoSeri())) {
            throw new \Exception("So Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }
        $query = "UPDATE GIOHANG SET soSeri = ? WHERE email = ? AND idSanPham = ?";
        $args = [$e->getSoSeri(), $e->getEmail(), $e->getIdSanPham()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Xóa một bản ghi từ bảng GIOHANG
     */
    public function delete(int $id): int
    {
        // Giả sử $id là một mảng chứa email và idSanPham
        if (!is_array($id) || !isset($id['email']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và soSeri");
        }

        $query = "DELETE FROM giohang WHERE  = ? AND SOSERI = ?";
        $rs = database_connection::executeUpdate($query, $id['email'], $id['soSeri']);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists(int $id): bool
    {
        if (!is_array($id) || !isset($id['email']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và soSeri");
        }

        $query = "SELECT COUNT(*) as count FROM giohang WHERE EMAIL = ? AND SOSERI = ?";
        $rs = database_connection::executeQuery($query, $id['email'], $id['soSeri']);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    /**
     * Tìm kiếm bản ghi theo điều kiện
     */
    public function search(string $condition, array $columnNames = []): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Điều kiện tìm kiếm không được để trống");
        }

        $columns = empty($columnNames)
            ? ['EMAIL', 'IDSANPHAM', 'SOSERI']
            : $columnNames;

        $query = "SELECT * FROM giohang WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
        $args = array_fill(0, count($columns), "%" . $condition . "%");
        $rs = database_connection::executeQuery($query, ...$args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createGioHangModel($row);
        }
        return $list;
    }
}
?>