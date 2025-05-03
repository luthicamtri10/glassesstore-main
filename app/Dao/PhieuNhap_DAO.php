<?php

namespace App\Dao;

use App\Enum\ReceiptStatus;
use App\Interface\DAOInterface;
use App\Models\PhieuNhap;
use App\Services\database_connection;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use App\Bus\NCC_BUS;

use function Laravel\Prompts\error;

class PhieuNhap_DAO implements DAOInterface
{
   

    public function readDatabase(): array
    {
        $list = [];
        try {
            $connection = database_connection::getInstance();
            if (!$connection->checkConnection()) {
                error_log("Database connection failed");
                return $list;
            }

            $rs = database_connection::executeQuery("SELECT * FROM PHIEUNHAP");
            error_log("SQL Query executed: SELECT * FROM PHIEUNHAP");
            
            if ($rs && $rs->num_rows > 0) {
                error_log("Number of rows: " . $rs->num_rows);
                while ($row = $rs->fetch_assoc()) {
                    error_log("Row data: " . print_r($row, true));
                    $model = $this->createPhieuNhapModel($row);
                    if ($model) {
                        array_push($list, $model);
                    }
                }
            } else {
                error_log("No result set returned from query");
            }
        } catch (\Exception $e) {
            error_log("Error in readDatabase: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
        }
        return $list;
    }

    public function createPhieuNhapModel($rs): ?PhieuNhap
    {
        try {
            if (!$rs || !is_array($rs)) {
                error_log("Invalid data for creating PhieuNhap model");
                return null;
            }

            error_log("Creating PhieuNhap model with data: " . print_r($rs, true));

            $id = $rs['ID'] ?? null;
            $idNCC = $rs['IDNCC'] ?? null;
            $tongTien = $rs['TONGTIEN'] ?? 0;
            $ngayTao = $rs['NGAYTAO'] ?? date('Y-m-d');
            $idNhanVien = $rs['IDNHANVIEN'] ?? null;
            $trangThai = $rs['TRANGTHAIHD'] ?? 0;

            if (!$id || !$idNCC || !$idNhanVien) {
                error_log("Missing required fields for PhieuNhap model");
                return null;
            }

            // Convert date string to DateTime object
            $ngayTaoObj = \DateTime::createFromFormat('Y-m-d', $ngayTao);
            if (!$ngayTaoObj) {
                error_log("Invalid date format: " . $ngayTao);
                $ngayTaoObj = new \DateTime();
            }

            // Convert status to enum
            $trangThaiEnum = $trangThai == 1 ? ReceiptStatus::PAID : ReceiptStatus::UNPAID;

            $model = new PhieuNhap(
                $id,
                $idNCC,
                $tongTien,
                $ngayTaoObj->format('Y-m-d'),
                $idNhanVien,
                $trangThaiEnum
            );

            error_log("Successfully created PhieuNhap model with ID: " . $id);
            return $model;
        } catch (\Exception $e) {
            error_log("Error in createPhieuNhapModel: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return null;
        }
    }

    public function getAll(): array
    {
        return $this->readDatabase();
    }

    public function getById($id): ?PhieuNhap
    {
        try {
            $query = "SELECT * FROM PHIEUNHAP WHERE ID = ?";
            $rs = database_connection::executeQuery($query, $id);
            
            if ($rs && $rs->num_rows > 0) {
                $row = $rs->fetch_assoc();
                return $this->createPhieuNhapModel($row);
            }
            return null;
        } catch (\Exception $e) {
            error_log("Error in getById: " . $e->getMessage());
            return null;
        }
    }

    public function insert($model): int
    {
        try {
            if (!$model instanceof PhieuNhap) {
                error_log("Invalid model type for insert");
                return 0;
            }

            $ngayTao = $model->getNgayTao();
            if (!$ngayTao) {
                $ngayTao = date('Y-m-d');
            } elseif (is_string($ngayTao)) {
                $ngayTao = date('Y-m-d', strtotime($ngayTao));
            } else {
                $ngayTao = $ngayTao->format('Y-m-d');
            }

            $query = "INSERT INTO PHIEUNHAP (ID, IDNCC, TONGTIEN, NGAYTAO, IDNHANVIEN, TRANGTHAIHD) VALUES (?, ?, ?, ?, ?, ?)";
            $args = [
                $model->getId(),
                $model->getIdNCC(),
                $model->getTongTien(),
                $ngayTao,
                $model->getIdNhanVien(),
                $model->getTrangThaiPN()->value == 'PAID' ? 1 : 0
            ];

            $result = database_connection::executeUpdate($query, ...$args);
            error_log("Insert result: " . print_r($result, true));
            
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in insert: " . $e->getMessage());
            return 0;
        }
    }

    public function update($model): int
    {
        try {
            $query = "UPDATE PHIEUNHAP SET IDNCC = ?, TONGTIEN = ?, NGAYTAO = ?, IDNHANVIEN = ?, TRANGTHAIHD = ? WHERE ID = ?";
            $args = [
                $model->getIdNCC(),
                $model->getTongTien(),
                $model->getNgayTao()->format('Y-m-d'),
                $model->getIdNhanVien(),
                $model->getTrangThaiPN()->value,
                $model->getId()
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
            $query = "DELETE FROM PHIEUNHAP WHERE ID = ?";
            $result = database_connection::executeUpdate($query, $id);
    
            return is_int($result) ? $result : 0;
        } catch (\Exception $e) {
            error_log("Error in delete: " . $e->getMessage());
            return 0;
        }
    }
    

    public function exists(int $id): bool
    {
        try {
            $query = "SELECT COUNT(*) as count FROM PHIEUNHAP WHERE ID = ?";
            $rs = database_connection::executeQuery($query, $id);
            if ($rs) {
                $row = $rs->fetch_assoc();
                return $row['count'] > 0;
            }
        } catch (\Exception $e) {
            error_log("Error in exists: " . $e->getMessage());
        }
        return false;
    }

    public function search($value, $columns): array
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }

        $columns = empty($columns) ? ["ID", "IDNCC", "TONGTIEN", "IDNHANVIEN", "NGAYTAO"] : $columns;
        $query = "SELECT * FROM PHIEUNHAP WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
        $args = array_fill(0, count($columns), "%" . $value . "%");

        try {
            $rs = database_connection::executeQuery($query, ...$args);
            $list = [];
            if ($rs) {
                while ($row = $rs->fetch_assoc()) {
                    $model = $this->createPhieuNhapModel($row);
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
