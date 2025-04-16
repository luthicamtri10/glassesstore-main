<?php
namespace App\Dao;

use App\Bus\NguoiDung_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Interface\DAOInterface;
use App\Models\GioHang;
use App\Services\database_connection;
use InvalidArgumentException;

class GioHang_DAO implements DAOInterface
{
    /**
     * Đọc toàn bộ dữ liệu từ bảng GIOHANG
     */
    private $tkBUS;
    public function __construct(TaiKhoan_BUS $tkBUS)
    {
        $this->tkBUS = $tkBUS;
        
    }
    public function readDatabase(): array
    {
        $list = [];
        $query = "SELECT * FROM giohang WHERE TRANGTHAIHD = 1"; // Chỉ lấy các bản ghi có trạng thái hoạt động
        $rs = database_connection::executeQuery($query);
        
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
        $id = $rs['ID'];
        $taiKhoan = $this->tkBUS->getModelById($rs['EMAIL']) ; // Cột EMAIL là một chuỗi, không cần gọi NguoiDung_BUS
        $createdAt = $rs['CREATEDAT'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        
        return new GioHang($id, $taiKhoan, $createdAt, $trangThaiHD);
    }

    /**
     * Lấy tất cả bản ghi từ bảng GIOHANG
     */
    public function getAll(): array
    {
        return $this->readDatabase();
    }

    /**
     * Lấy một bản ghi theo ID
     */
    public function getById($id)
    {
        $query = "SELECT * FROM giohang WHERE ID = ? AND TRANGTHAIHD = 1";
        $result = database_connection::executeQuery($query, $id);
        
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
        $query = "INSERT INTO giohang (EMAIL, CREATEDAT, TRANGTHAIHD) VALUES (?,?,?)";
        $args = [ $e->getTaiKhoan()->getEmail(), $e->getCreatedAt(), $e->getTrangThaiHD()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
        return 0;
    }

    /**
     * Cập nhật một bản ghi trong bảng GIOHANG
     */
    public function update($e): int
    {
        $query = "UPDATE giohang SET EMAIL = ?, CREATEDAT = ? WHERE ID = ?";
        $args = [$e->getTaiKhoan()->getEmail(), $e->getCreatedAt(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Xóa một bản ghi từ bảng GIOHANG (xóa mềm)
     */
    public function delete(int $id): int
    {
        $query = "UPDATE giohang SET TRANGTHAIHD = 0 WHERE ID = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists(int $id): bool
    {
        if (empty($id) || !is_numeric($id)) {
            throw new InvalidArgumentException("ID phải là một số nguyên hợp lệ");
        }

        $query = "SELECT COUNT(*) as count FROM giohang WHERE ID = ? AND TRANGTHAIHD = 1";
        $rs = database_connection::executeQuery($query, [$id]);
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

        // Chỉ sử dụng các cột có trong bảng giohang
        $columns = empty($columnNames)
            ? ['EMAIL']
            : array_intersect($columnNames, ['ID','EMAIL', 'CREATEDAT', 'TRANGTHAIHD']);

        if (empty($columns)) {
            throw new InvalidArgumentException("Không có cột hợp lệ để tìm kiếm");
        }

        $query = "SELECT * FROM giohang WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ? AND TRANGTHAIHD = 1";
        $args = array_fill(0, count($columns), "%" . $condition . "%");
        $rs = database_connection::executeQuery($query, $args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createGioHangModel($row);
        }
        return $list;
    }
}
?>