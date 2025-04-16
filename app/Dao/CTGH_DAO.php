<?php

namespace App\Dao;

use App\Bus\GioHang_BUS;
use App\Interface\DAOInterface;
use App\Models\CTGH;
use App\Services\database_connection;
use CTSP_BUS;
use InvalidArgumentException;

class CTGH_DAO
{
    /**
     * Đọc toàn bộ dữ liệu từ bảng CTGH
     */
    private $ghBUS;
    private $ctspBUS;
    public function __construct(GioHang_BUS $ghBUS, CTSP_BUS $ctspBUS)
    {
        $this->$ghBUS = $ghBUS;
        $this->$ctspBUS = $ctspBUS;
    }
    public function readDatabase(): array
    {
        $list = [];
        $query = "SELECT * FROM ctgh";
        $rs = database_connection::executeQuery($query);

        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTGHModel($row);
            $list[] = $model;
        }
        return $list;
    }

    /**
     * Tạo mô hình CTGH từ dữ liệu cơ sở dữ liệu
     */
    private function createCTGHModel(array $rs): CTGH
    {
        $ghModel = $this->ghBUS->getModelById($rs['IDGH']);
        $ctspModel = $this->ctspBUS->getModelById($rs['IDGH']);

        return new CTGH($ghModel, $ctspModel);
    }

    /**
     * Lấy tất cả bản ghi từ bảng CTGH
     */
    public function getAll(): array
    {
        return $this->readDatabase();
    }

    /**
     * Lấy một bản ghi theo ID
     */
    public function getById(string $soseri, int $idgh): ?CTGH
    {
        if (empty($soseri) || !is_string($soseri) || empty($idgh) || !is_numeric($idgh)) {
            throw new InvalidArgumentException("Số seri phải là chuỗi hợp lệ và IDGH phải là số nguyên hợp lệ");
        }

        $query = "SELECT * FROM ctgh WHERE SOSERI = ? AND IDGH = ?";
        $result = database_connection::executeQuery($query,[$soseri, $idgh] );

        if ($result->num_rows > 0) {
            return $this->createCTGHModel($result->fetch_assoc());
        }
        return null;
    }

    /**
     * Thêm một bản ghi vào bảng CTGH
     */
    public function insert($e): int
    {
        if (!$e instanceof CTGH) {
            throw new InvalidArgumentException("Tham số phải là instance của CTGH");
        }

        $query = "INSERT INTO ctgh (IDGH, SOSERI) VALUES (?, ?)";
        $args = [
            $e->getGioHang()->getId(),
            $e->getCTSP()->getSoSeri()
        ];
        $rs = database_connection::executeQuery($query, $args);

        // Trả về ID của bản ghi vừa thêm (nếu executeQuery trả về ID)
        return is_int($rs) ? $rs : 0;
    }



    /**
     * Xóa một bản ghi từ bảng CTGH (xóa cứng)
     */
    public function delete(string $soseri, int $idgh): int
    {
        if (empty($soseri) || !is_string($soseri) || empty($idgh) || !is_numeric($idgh)) {
            throw new InvalidArgumentException("Số seri phải là chuỗi hợp lệ và IDGH phải là số nguyên hợp lệ");
        }
        $query = "DELETE FROM ctgh WHERE SOSERI = ? AND IDGH = ?";
        $rs = database_connection::executeUpdate($query, [$soseri, $idgh]);

        return is_int($rs) ? $rs : 0;
    }

    /**
     * Kiểm tra xem một bản ghi có tồn tại không
     */
    public function exists(string $soseri, int $idgh): bool
    {
        if (empty($soseri) || !is_string($soseri) || empty($idgh) || !is_numeric($idgh)) {
            throw new InvalidArgumentException("Số seri phải là chuỗi hợp lệ và IDGH phải là số nguyên hợp lệ");
        }
        $query = "SELECT COUNT(*) as count FROM ctgh WHERE IDGH = ? AND SOSERI = ?";
        $rs = database_connection::executeQuery($query, [$idgh, $soseri]);
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

        // Chỉ sử dụng các cột có trong bảng ctgh
        $columns = empty($columnNames)
            ? ['SOSERI'] // Mặc định tìm kiếm trên SOSERI
            : array_intersect($columnNames, ['IDGH', 'SOSERI']);

        if (empty($columns)) {
            throw new InvalidArgumentException("Không có cột hợp lệ để tìm kiếm");
        }

        // Tạo điều kiện truy vấn
        $conditions = [];
        $args = [];
        foreach ($columns as $column) {
            if ($column === 'IDGH') {
                // Tìm kiếm chính xác trên cột số IDGH
                $conditions[] = "$column = ?";
                $args[] = (int)$condition; // Ép kiểu thành int cho IDGH
            } else {
                // Tìm kiếm gần đúng trên SOSERI
                $conditions[] = "$column LIKE ?";
                $args[] = "%" . $condition . "%"; // Giữ nguyên chuỗi cho SOSERI
            }
        }

        $query = "SELECT * FROM ctgh WHERE " . implode(" OR ", $conditions);
        $rs = database_connection::executeQuery($query, $args);

        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createCTGHModel($row);
        }
        return $list;
    }

    /**
     * Lấy tất cả chi tiết giỏ hàng theo GIOHANGID
     */
    public function getByGioHangId(int $gioHangId): array
    {
        if (empty($gioHangId) || !is_numeric($gioHangId)) {
            throw new InvalidArgumentException("GIOHANGID phải là một số nguyên hợp lệ");
        }

        $list = [];
        $query = "SELECT * FROM ctgh WHERE IDGH = ?";
        $rs = database_connection::executeQuery($query, [$gioHangId]);

        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createCTGHModel($row);
        }
        return $list;
    }
}
