<?php

namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\CTPN;
use App\Services\database_connection;

class CTPN_DAO implements DAOInterface {
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM CTPN");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTPNModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function createCTPNModel($rs): CTPN {
        $idPN = $rs['idPN'];
        $idSP = $rs['idSP'];
        $soLuong = $rs['soLuong'];
        $giaNhap = $rs['giaNhap'];
        $phanTramLN = $rs['phanTramLN'];

        return new CTPN($idPN, $idSP, $soLuong, $giaNhap, $phanTramLN);
    }

    public function getAll(): array {
        return $this->readDatabase();
    }

    public function getById($idPN, $idSP): ?CTPN {
        $sql = "SELECT * FROM CTPN WHERE idPN = ? AND idSP = ?";
        $rs = database_connection::executeQuery($sql, $idPN, $idSP);
        if ($row = $rs->fetch_assoc()) {
            return $this->createCTPNModel($row);
        }
        return null;
    }

    public function getByPhieuNhapId($idPN): array {
        $list = [];
        $sql = "SELECT * FROM CTPN WHERE idPN = ?";
        $rs = database_connection::executeQuery($sql, $idPN);
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTPNModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function insert($e): int {
        $sql = "INSERT INTO CTPN (idPN, idSP, soLuong, giaNhap, phanTramLN) 
        VALUES (?, ?, ?, ?, ?)";
        $args = [
            $e->getIdPN(), 
            $e->getIdSP(), 
            $e->getSoLuong(), 
            $e->getGiaNhap(), 
            $e->getPhanTramLN()
        ];
        return database_connection::executeQuery($sql, ...$args);
    }

    public function update($e): int {
        $sql = "UPDATE CTPN SET soLuong = ?, giaNhap = ?, phanTramLN = ? 
        WHERE idPN = ? AND idSP = ?";
        $args = [
            $e->getSoLuong(), 
            $e->getGiaNhap(), 
            $e->getPhanTramLN(),
            $e->getIdPN(), 
            $e->getIdSP()
        ];
        return database_connection::executeUpdate($sql, ...$args);
    }

    public function delete(int $id): int {
        // For CTPN, we need both idPN and idSP, so we'll split the id
        $ids = explode('_', $id);
        if (count($ids) !== 2) {
            return 0;
        }
        $idPN = $ids[0];
        $idSP = $ids[1];
        $sql = "DELETE FROM CTPN WHERE idPN = ? AND idSP = ?";
        return database_connection::executeUpdate($sql, $idPN, $idSP);
    }

    public function deleteByPhieuNhapId($idPN): int {
        $sql = "DELETE FROM CTPN WHERE idPN = ?";
        return database_connection::executeUpdate($sql, $idPN);
    }

    public function search(string $condition, array $columnNames): array {
        $sql = "SELECT * FROM CTPN WHERE ";
        $whereClauses = [];
        foreach ($columnNames as $column) {
            $whereClauses[] = "$column LIKE ?";
        }
        $sql .= implode(" AND ", $whereClauses);
        
        $params = array_fill(0, count($columnNames), "%$condition%");
        $rs = database_connection::executeQuery($sql, ...$params);
        
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createCTPNModel($row);
            array_push($list, $model);
        }
        return $list;
    }
}