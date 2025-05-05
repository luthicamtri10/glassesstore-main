<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\ChiTietBaoHanh;
use App\Services\database_connection;
use InvalidArgumentException;

class ChiTietBaoHanh_DAO implements DAOInterface
{
    /**
     * Đọc toàn bộ dữ liệu từ bảng CHITIETBAOHANH
     * @return ChiTietBaoHanh[]
     */
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CHITIETBAOHANH");
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }

    /**
     * Tạo mô hình ChiTietBaoHanh từ dữ liệu cơ sở dữ liệu
     */
    private function createModel(array $row): ChiTietBaoHanh
    {
        return new ChiTietBaoHanh(
            (int)$row['idKhachHang'],
            (int)$row['idSanPham'],
            (float)$row['chiPhiBaoHanh'],
            $row['thoiDiemBaoHanh'],
            $row['soSeri']
        );
    }

    /**
     * Lấy tất cả bản ghi từ bảng CHITIETBAOHANH
     * @return ChiTietBaoHanh[]
     */
    public function getAll(): array
    {
        return $this->readDatabase();
    }

    /**
     * Lấy một bản ghi theo idKhachHang và idSanPham
     */
    public function getById($id): ?ChiTietBaoHanh
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }

        $query = "SELECT * FROM CHITIETBAOHANH WHERE idKhachHang = ? AND idSanPham = ?";
        $result = database_connection::executeQuery($query, $id['idKhachHang'], $id['idSanPham']);

        if ($result->num_rows > 0) {
            return $this->createModel($result->fetch_assoc());
        }
        return null;
    }

    /**
     * Thêm một bản ghi vào bảng CHITIETBAOHANH
     */
    public function insert($e): int
    {
        if (!$e instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Tham số phải là instance của ChiTietBaoHanh");
        }

        $query = "INSERT INTO CHITIETBAOHANH (idKhachHang, idSanPham, chiPhiBaoHanh, thoiDiemBaoHanh, soSeri) VALUES (?, ?, ?, ?, ?)";
        $args = [
            $e->getIdKhachHang(),
            $e->getIdSanPham(),
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s'), // Chuyển DateTime thành chuỗi
            $e->getSoSeri()
        ];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Cập nhật một bản ghi trong bảng CHITIETBAOHANH
     */
    public function update($e): int
    {
        if (!$e instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Tham số phải là instance của ChiTietBaoHanh");
        }

        $query = "UPDATE CHITIETBAOHANH SET chiPhiBaoHanh = ?, thoiDiemBaoHanh = ?, soSeri = ? WHERE idKhachHang = ? AND idSanPham = ?";
        $args = [
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s'), // Chuyển DateTime thành chuỗi
            $e->getSoSeri(),
            $e->getIdKhachHang(),
            $e->getIdSanPham()
        ];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Xóa một bản ghi từ bảng CHITIETBAOHANH
     */
    public function delete($id): int
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }

        $query = "DELETE FROM CHITIETBAOHANH WHERE idKhachHang = ? AND idSanPham = ?";
        $rs = database_connection::executeUpdate($query, $id['idKhachHang'], $id['idSanPham']);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists($id): bool
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }

        $query = "SELECT COUNT(*) as count FROM CHITIETBAOHANH WHERE idKhachHang = ? AND idSanPham = ?";
        $rs = database_connection::executeQuery($query, $id['idKhachHang'], $id['idSanPham']);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    /**
     * Tìm kiếm bản ghi theo điều kiện
     * @return ChiTietBaoHanh[]
     */
    public function search(string $condition, array $columnNames = []): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Điều kiện tìm kiếm không được để trống");
        }

        $columns = empty($columnNames)
            ? ['idKhachHang', 'idSanPham', 'chiPhiBaoHanh', 'thoiDiemBaoHanh', 'soSeri']
            : $columnNames;

        $query = "SELECT * FROM CHITIETBAOHANH WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
        $args = array_fill(0, count($columns), "%" . $condition . "%");
        $rs = database_connection::executeQuery($query, ...$args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }
}
?>