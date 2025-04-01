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
        $rs = database_connection::executeQuery("SELECT * FROM chitietbaohanh WHERE TRANGTHAIHD = 1");
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
    
        $idKhachHang = app(NguoiDung_BUS::class)->getModelById($rs['idNguoiDung']);
        $idSanPham = app(SanPham_BUS::class)->getModelById($rs['idSanPham']);
        $soSeri = $rs['soSeri'];
        $chiPhiBH = $rs['chiPhiBH'];
        $thoiDiemBH = $rs['thoiDiemBH'];
        $trangThaiHD = $rs['trangthai'];
        return new ChiTietBaoHanh($idKhachHang, $idSanPham, $chiPhiBH, $thoiDiemBH, $soSeri,$trangThaiHD);
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
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])|| !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham va soSeri");
        }

        $query = "SELECT * FROM chitietbaohanh WHERE IDKHACHHANG = ? AND IDSANPHAM = ? AND SOSERI = ? AND TRANGTHAIHD = 1";
        $result = database_connection::executeQuery($query, $id['idKhachHang'], $id['idSanPham'],$id['idKhachHang']) ;

        if ($result->num_rows > 0) {
            return $this->createModel($result->fetch_assoc());
        }
        return null;
    }

    /**
     * Kiểm tra tính hợp lệ của sản phẩm trong hóa đơn trước khi tạo chi tiết bảo hành
     */
    private function isValidForWarranty(int $idKhachHang, int $idSanPham, string $soSeri): bool
    {
        $query = "SELECT cthd.TRANGTHAIBH
                  FROM hoadon hd 
                  INNER JOIN chitiethoadon cthd 
                  ON hd.ID = cthd.IDHD 
                  WHERE cthd.SOSERI = ? AND cthd.IDSP = ? AND hd.IDKHACHHANG = ? AND hd.TRANGTHAI = 'PAID'";
        $rs = database_connection::executeQuery($query, $soSeri, $idSanPham, $idKhachHang);
        
        if ($rs->num_rows === 0) {
            return false; // Không tìm thấy hóa đơn
        }

        $row = $rs->fetch_assoc();
        if ($row['TRANGTHAIBH'] !== 1) {
            return false; // Hết bảo hành
        }

        return true;
    }
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
        if (!$e instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Tham số phải là instance của ChiTietBaoHanh");
        }
        if (!$this->productExists($e->getIdSanPham())) {
            throw new \Exception("ID sanpham {$e->getIdSanPham()} không tồn tại trong bảng sanpham.");
        }
        if (!$this->soSeriExists($e->getIdSanPham(),$e->getSoSeri())) {
            throw new \Exception("So Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }
        if (!$this->customerExists($e->getIdKhachHang())) {
            throw new \Exception("ID KHACHHANG {$e->getSoSeri()} không tồn tại trong bảng NGÙODUNG.");
        }
        

        // Kiểm tra tính hợp lệ trước khi thêm
        if (!$this->isValidForWarranty($e->getIdKhachHang(), $e->getIdSanPham(), $e->getSoSeri())) {
            throw new \Exception("Sản phẩm không đủ điều kiện bảo hành.");
        }
        if ($this->exists($e->getIdKhachHang(), $e->getIdSanPham(), $e->getSoSeri())) {
            throw new \Exception("Bản ghi bảo hành đã tồn tại cho khách hàng, sản phẩm và số seri này.");
        }

        $query = "INSERT INTO chitietbaohanh (IDKHACHHANG, IDSANPHAM, CHIPHIBH, THOIDIEMBAOHANH, SOSERI,TRANGTHAIHD) 
                  VALUES (?, ?, ?, ?, ?,?)";
        $args = [
            $e->getIdKhachHang(),
            $e->getIdSanPham(),
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s'),
            $e->getSoSeri(),
            $e->getTrangThaiHD()
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
        if (!$this->productExists($e->getIdSanPham())) {
            throw new \Exception("ID sanpham {$e->getIdSanPham()} không tồn tại trong bảng sanpham.");
        }
        if (!$this->soSeriExists($e->getIdSanPham(),$e->getSoSeri())) {
            throw new \Exception("So Seri {$e->getSoSeri()} không tồn tại trong bảng ctsp.");
        }
        if (!$this->customerExists($e->getIdKhachHang())) {
            throw new \Exception("ID KHACHHANG {$e->getSoSeri()} không tồn tại trong bảng NGÙODUNG.");
        }
        

        $query = "UPDATE chitietbaohanh SET CHIPHIBH = ?, THOIDIEMBAOHANH = ?,TRANGTHAIHD = ?
                  WHERE SOSERI = ? AND IDKHACHHANG = ? AND IDSANPHAM = ?";
        $args = [
            $e->getChiPhiBH(),
            $e->getThoiDiemBH()->format('Y-m-d H:i:s'),
            $e->getTrangThaiHD(),
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
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])|| !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham và soSeri");
        }

        $query = "UPDATE FROM chitietbaohanh SET TRANGTHAIHD = 0 WHERE IDKHACHHANG = ? AND IDSANPHAM = ? AND SOSERI = ?";
        $rs = database_connection::executeUpdate($query, $id['idKhachHang'], $id['idSanPham'], $id["soSeri"]);
        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists($id): bool
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])|| !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }

        $query = "SELECT COUNT(*) as count FROM chitietbaohanh WHERE IDKHACHHANG = ? AND IDSANPHAM = ? AND SOSERI = ?";
        $rs = database_connection::executeQuery($query, $id['idKhachHang'], $id['idSanPham'], $id["soSeri"]);
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
            ? ['IDKHACHHANG', 'IDSANPHAM', 'CHIPHIBH', 'THOIDIEMBAOHANH', 'SOSERI']
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
?>