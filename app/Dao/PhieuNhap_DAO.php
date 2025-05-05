<?php

namespace App\Dao;
use App\Bus\NguoiDung_BUS;
use App\Bus\NCC_BUS;
use App\Enum\ReceiptStatus;
use App\Interface\DAOInterface;
use App\Models\PhieuNhap;
use App\Services\database_connection;
use Illuminate\Support\Arr;
use InvalidArgumentException;

use function Laravel\Prompts\error;

class PhieuNhap_DAO implements DAOInterface
{
    private $nccBUS;
    private $ndBUS;
    public function __construct(NCC_BUS $ncc_bus, NguoiDung_BUS $nguoi_dung_bus)
    {
        $this->nccBUS = $ncc_bus;
        $this->ndBUS = $nguoi_dung_bus;
        
    }
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM phieunhap");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            $list[] = $model;
        }
        return $list;
    }
    public function createPhieuNhapModel($rs)
    {
        $trangThaiHD = $rs['TRANGTHAIHD'];
        $id = $rs['ID'];
        $NCC = $this->nccBUS->getModelById($rs['IDNCC']);
        $tongTien = $rs['TONGTIEN'];
        $ngayTao = $rs['NGAYTAO'];
        $NhanVien = $this->ndBUS->getModelById($rs['IDNHANVIEN']);
        return new PhieuNhap($id,$NCC,$tongTien,$ngayTao,$NhanVien,$trangThaiHD);
    }
    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM phieunhap WHERE TRANGTHAIHD <> 0");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createPhieuNhapModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id): ?PhieuNhap
    {
        $query = "SELECT * FROM phieunhap WHERE ID = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            return $this->createPhieuNhapModel($result->fetch_assoc());
        }
        return null;
    }
   
    public function insert($e): int
    {
        $query = "INSERT INTO phieunhap (IDNCC, TONGTIEN, NGAYTAO, IDNHANVIEN, TRANGTHAIHD) VALUES (?,?,?,?,?)";
        $args = [ $e->getNCC()->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getNhanVien()->getId(), $e->getTrangThaiHD()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
        return 0;
    }
    public function update($e): int
    {
        $query = "UPDATE phieunhap SET IDNCC = ?, TONGTIEN = ?, NGAYTAO = ?, IDNHANVIEN = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$e->getNCC()->getIdNCC(), $e->getTongTien(), $e->getNgayTao(), $e->getNhanVien()->getId(), $e->getTrangThaiHD(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function delete(int $id): int
    {
        $query = "UPDATE phieunhap SET TRANGTHAIHD = 0 WHERE ID = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }
    public function exists(int $id): bool
    {
        $query = "SELECT COUNT(*) as count FROM phieunhap WHERE ID = ?";
        $rs = database_connection::executeQuery($query, $id);
        $row = $rs->fetch_assoc();
        return $row['count'] > 0;
    }

    public function search(string $condition, array $columnNames = []): array
    {
        
        // Danh sách cột mặc định nếu không truyền vào
        $columns = empty($columnNames)
            ? ["ID", "IDNCC", "TONGTIEN", "IDNHANVIEN", "NGAYTAO", "TRANGTHAIHD"]
            : $columnNames;

        // Xây dựng câu lệnh SQL với các cột được chỉ định
        $query = "SELECT * FROM phieunhap WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";

        // Mảng chứa các tham số tìm kiếm
        $args = array_fill(0, count($columns), "%" . $condition . "%");

        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];

        while ($row = $rs->fetch_assoc()) {
            $list[] = $this->createPhieuNhapModel($row);
        }

        return $list;
    }
}