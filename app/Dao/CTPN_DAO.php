<?php

namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\CTPN;
use App\Services\database_connection;
use InvalidArgumentException;
use App\Bus\SanPham_BUS;

class CTPN_DAO implements DAOInterface {
    private static $instance;
    private $sanPhamBus;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CTPN_DAO();
        }
        return self::$instance;
    }

    public function __construct()
    {
        // $this->sanPhamBus = SanPham_BUS::getInstance();
    }

    public function readDatabase(): array
    {
        $list = [];
        try {
            $rs = database_connection::executeQuery("SELECT * FROM CTPN");
            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $model = $this->createCTPNModel($row);
                    array_push($list, $model);
                }
            }
        } catch (\Exception $e) {
            error_log("Error in readDatabase: " . $e->getMessage());
        }
        return $list;
    }

    public function createCTPNModel($rs): CTPN {
        $model = new CTPN(
            $rs['IDPN'],
            $rs['IDSP'],
            $rs['SOLUONG'],
            $rs['GIANHAP'],
            $rs['PHANTRAMLN']
        );

        // Lấy thông tin sản phẩm
        // $sanPham = $this->sanPhamBus->getModelById($rs['IDSP']);
        // $model->setSanPham($sanPham);

        return $model;
    }

    public function getAll(): array {
        return $this->readDatabase();
    }

    public function getById($idPN, $idSP): ?CTPN {
        try {
            $query = "SELECT * FROM CTPN WHERE IDPN = ? AND IDSP = ?";
            $rs = database_connection::executeQuery($query, $idPN, $idSP);
            if ($rs && $rs->num_rows > 0) {
                $row = $rs->fetch_assoc();
                if ($row) {
                    return $this->createCTPNModel($row);
                }
            }
        } catch (\Exception $e) {
            error_log("Error in getById: " . $e->getMessage());
        }
        return null;
    }

    public function getByPhieuNhapId($idPN): array {
        $list = [];
        try {
            $query = "SELECT * FROM CTPN WHERE IDPN = ?";
            $rs = database_connection::executeQuery($query, $idPN);
            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $model = $this->createCTPNModel($row);
                    array_push($list, $model);
                }
            }
        } catch (\Exception $e) {
            error_log("Error in getByPhieuNhapId: " . $e->getMessage());
        }
        return $list;
    }

    public function insert($model): int {
        try {
            $query = "INSERT INTO CTPN (IDPN, IDSP, SOLUONG, GIANHAP, PHANTRAMLN) VALUES (?, ?, ?, ?, ?)";
            $args = [
                $model->getIdPN(),
                $model->getIdSP(),
                $model->getSoLuong(),
                $model->getGiaNhap(),
                $model->getPhanTramLN()
            ];
            $result = database_connection::executeUpdate($query, ...$args);
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in insert: " . $e->getMessage());
            return 0;
        }
    }

    public function update($model): int {
        try {
            $query = "UPDATE CTPN SET SOLUONG = ?, GIANHAP = ?, PHANTRAMLN = ? WHERE IDPN = ? AND IDSP = ?";
            $args = [
                $model->getSoLuong(),
                $model->getGiaNhap(),
                $model->getPhanTramLN(),
                $model->getIdPN(),
                $model->getIdSP()
            ];
            $result = database_connection::executeUpdate($query, ...$args);
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in update: " . $e->getMessage());
            return 0;
        }
    }

    public function delete($id): int
    {
        try {
            $query = "DELETE FROM CTPN WHERE IDPN = ? AND IDSP = ?";
            $result = database_connection::executeUpdate($query, $id);
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in delete: " . $e->getMessage());
            return 0;
        }
    }

    public function deleteByPhieuNhapId($idPN): int {
        try {
            $query = "DELETE FROM CTPN WHERE IDPN = ?";
            $result = database_connection::executeUpdate($query, $idPN);
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in deleteByPhieuNhapId: " . $e->getMessage());
            return 0;
        }
    }

    public function search($value, $columns): array {
        if (empty($value)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $columns = empty($columns) ? ["IDPN", "IDSP", "SOLUONG", "GIANHAP", "PHANTRAMLN"] : $columns;
        $query = "SELECT * FROM CTPN WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
        $args = array_fill(0, count($columns), "%" . $value . "%");

        try {
            $rs = database_connection::executeQuery($query, ...$args);
            $list = [];
            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $model = $this->createCTPNModel($row);
                    array_push($list, $model);
                }
            }
            return $list;
        } catch (\Exception $e) {
            error_log("Error in search: " . $e->getMessage());
            return [];
        }
    }
}