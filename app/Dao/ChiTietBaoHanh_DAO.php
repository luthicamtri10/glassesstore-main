<?php

namespace App\Dao;

use App\Bus\NguoiDung_BUS;
use App\Bus\SanPham_BUS;

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
        $rs = database_connection::executeQuery("SELECT * FROM chitietbaohanh");
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }

    /**
     * Tạo mô hình ChiTietBaoHanh từ dữ liệu cơ sở dữ liệu
     */
    private function createModel(array $rs): ChiTietBaoHanh
    {

        $idKhachHang = app(NguoiDung_BUS::class)->getModelById($rs['IDKHACHHANG']);
        $soSeri = $rs['SOSERI'];
        $chiPhiBH = $rs['CHIPHIBH'];
        $thoiDiemBH = $rs['THOIDIEMBAOHANH'];
        return new ChiTietBaoHanh($idKhachHang, $soSeri, $chiPhiBH, $thoiDiemBH);
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
        // Kiểm tra tính hợp lệ của $id
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và soSeri");
        }

        // Truy vấn an toàn với tham số đúng
        $query = "SELECT * FROM chitietbaohanh WHERE IDKHACHHANG = ? AND SOSERI = ?";
        $result = database_connection::executeQuery($query, $id['idKhachHang'], $id['soSeri']);

        if ($result->num_rows > 0) {
            return $this->createModel($result->fetch_assoc());
        }
        return null;
    }

    /**
     * Kiểm tra tính hợp lệ của sản phẩm trong hóa đơn trước khi tạo chi tiết bảo hành
     */
    private function isValidForWarranty(int $idKhachHang, string $soSeri): bool
    {
        $query = "SELECT cthd.TRANGTHAIBH
                  FROM hoadon hd 
                  INNER JOIN chitiethoadon cthd 
                  ON hd.ID = cthd.IDHD 
                  WHERE cthd.SOSERI = ? AND hd.IDKHACHHANG = ? AND hd.TRANGTHAI = 'PAID'";
        $rs = database_connection::executeQuery($query, $soSeri, $idKhachHang);

        if ($rs->num_rows === 0) {
            return false; // Không tìm thấy hóa đơn
        }

        $row = $rs->fetch_assoc();
        if ($row['TRANGTHAIBH'] !== 1) {
            return false; // Hết bảo hành
        }

        return true;
    }

    private function soSeriExists(string $soSeri): bool
    {
        $query = "SELECT COUNT(*) as count FROM ctsp WHERE  SOSERI = ?";
        $rs = database_connection::executeQuery($query, $soSeri);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }
    private function customerExists(int $idKhachHang): bool
    {
        $query = "SELECT COUNT(*) as count FROM nguoidung WHERE ID = ?";
        $rs = database_connection::executeQuery($query, $idKhachHang);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }
    /**
     * Thêm một bản ghi vào bảng CHITIETBAOHANH
     */
    public function insert($e): int
    {
        // Kiểm tra kiểu dữ liệu đầu vào
        if (!$e instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Tham số phải là instance của ChiTietBaoHanh");
        }

        // Kiểm tra sự tồn tại của số seri
        if (!$this->soSeriExists($e->getSoSeri())) {
            throw new \Exception("Số Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }
        // Kiểm tra sự tồn tại của khách hàng
        if (!$this->customerExists($e->getIdKhachHang())) {
            throw new \Exception("ID KHACHHANG {$e->getIdKhachHang()} không tồn tại trong bảng NGUOIDUNG.");
        }

        // Kiểm tra điều kiện bảo hành
        if (!$this->isValidForWarranty($e->getIdKhachHang(), $e->getSoSeri())) {
            throw new \Exception("Sản phẩm không đủ điều kiện bảo hành.");
        }

        // Truy vấn chèn dữ liệu với số tham số khớp
        $query = "INSERT INTO chitietbaohanh (IDKHACHHANG, SOSERI, CHIPHIBH, THOIDIEMBAOHANH) 
              VALUES (?, ?, ?, ?)";
        $args = [
            $e->getIdKhachHang(),
            $e->getSoSeri(),
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s')
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

        if (!$this->soSeriExists($e->getSoSeri())) {
            throw new \Exception("So Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }
        if (!$this->customerExists($e->getIdKhachHang())) {
            throw new \Exception("ID KHACHHANG {$e->getSoSeri()} không tồn tại trong bảng NGÙODUNG.");
        }


        $query = "UPDATE chitietbaohanh SET CHIPHIBH = ?, THOIDIEMBAOHANH = ?
                  WHERE SOSERI = ? AND IDKHACHHANG = ?";
        $args = [
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s'),
            $e->getSoSeri(),
            $e->getIdKhachHang(),
        ];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Xóa một bản ghi từ bảng CHITIETBAOHANH
     */
    public function delete($id): int
    {
        // Kiểm tra tính hợp lệ của $id
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và soSeri");
        }

        // Sử dụng DELETE thay vì UPDATE
        $query = "DELETE FROM chitietbaohanh WHERE IDKHACHHANG = ? AND SOSERI = ?";
        $rs = database_connection::executeUpdate($query, $id['idKhachHang'], $id['soSeri']);
        return is_int($rs) ? $rs : 0;
    }
    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists($id): bool
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và soSeri");
        }

        $query = "SELECT COUNT(*) as count FROM chitietbaohanh WHERE IDKHACHHANG = ?  AND SOSERI = ?";
        $rs = database_connection::executeQuery($query, $id['idKhachHang'], $id["soSeri"]);
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
            ? ['IDKHACHHANG', 'CHIPHIBH', 'THOIDIEMBAOHANH', 'SOSERI']
            : $columnNames;

        $query = "SELECT * FROM chitietbaohanh WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
        $args = array_fill(0, count($columns), "%" . $condition . "%");
        $rs = database_connection::executeQuery($query, ...$args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createModel($row);
        }
        return $list;
    }
}
