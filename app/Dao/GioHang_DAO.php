<?php
namespace App\Dao;

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
        $rs = database_connection::executeQuery("SELECT * FROM GIOHANG");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createGioHangModel($row);
            $list[] = $model;
        }
        return $list;
    }

    /**
     * Tạo mô hình GioHang từ dữ liệu cơ sở dữ liệu
     */
    private function createGioHangModel(array $row): GioHang
    {
        return new GioHang(
            $row['email'],
            (int)$row['idSanPham'],
            $row['soSeri']
        );
    }

    /**
     * Lấy tất cả bản ghi từ bảng GIOHANG
     */
    public function getAll(): array
    {
        return $this->readDatabase();
    }

    /**
     * Lấy một bản ghi theo email và idSanPham (giả sử đây là khóa chính)
     */
    public function getById($id): ?GioHang
    {
        // Giả sử $id là một mảng chứa email và idSanPham
        if (!is_array($id) || !isset($id['email']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và idSanPham");
        }

        $query = "SELECT * FROM GIOHANG WHERE email = ? AND idSanPham = ?";
        $result = database_connection::executeQuery($query, $id['email'], $id['idSanPham']);
        
        if ($result->num_rows > 0) {
            return $this->createGioHangModel($result->fetch_assoc());
        }
        return null;
    }

    /**
     * Thêm một bản ghi vào bảng GIOHANG
     */
    public function insert($e): int
    {
        if (!$e instanceof GioHang) {
            throw new InvalidArgumentException("Tham số phải là instance của GioHang");
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
        if (!is_array($id) || !isset($id['email']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và idSanPham");
        }

        $query = "DELETE FROM GIOHANG WHERE email = ? AND idSanPham = ?";
        $rs = database_connection::executeUpdate($query, $id['email'], $id['idSanPham']);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists(int $id): bool
    {
        if (!is_array($id) || !isset($id['email']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa email và idSanPham");
        }

        $query = "SELECT COUNT(*) as count FROM GIOHANG WHERE email = ? AND idSanPham = ?";
        $rs = database_connection::executeQuery($query, $id['email'], $id['idSanPham']);
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
            ? ['email', 'idSanPham', 'soSeri']
            : $columnNames;

        $query = "SELECT * FROM GIOHANG WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
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