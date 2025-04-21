<?php

namespace App\Dao;

use App\Models\NCC;
use App\Services\database_connection;
use App\Interface\DAOInterface;

class NCC_DAO implements DAOInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NCC_DAO();
        }
        return self::$instance;
    }

    public function getAll(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM NCC");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createNCCModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM NCC WHERE ID = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->createNCCModel($row);
        }
        return null;
    }

    public function insert($model): int
    {
        $query = "INSERT INTO NCC (TENNCC, SODIENTHOAI, DIACHI, MOTA, TRANGTHAIHD) VALUES (?, ?, ?, ?, ?)";
        $args = [$model->getTenNCC(), $model->getSdtNCC(), $model->getDiachi(), $model->getMoTa(), $model->getTrangthaiHD()];
        return database_connection::executeUpdate($query, ...$args);
    }

    public function update($model): int
    {
        $query = "UPDATE NCC SET TENNCC = ?, SODIENTHOAI = ?, DIACHI = ?, MOTA = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$model->getTenNCC(), $model->getSdtNCC(), $model->getDiachi(), $model->getMoTa(), $model->getTrangthaiHD(), $model->getIdNCC()];
        return database_connection::executeUpdate($query, ...$args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM NCC WHERE ID = ?";
        return database_connection::executeUpdate($query, $id);
    }

    public function search($value, $columns): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columns));
        $query = "SELECT * FROM NCC WHERE $conditions";
        $params = array_fill(0, count($columns), "%$value%");
        $rs = database_connection::executeQuery($query, ...$params);
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createNCCModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    private function createNCCModel($row): NCC
    {
        return new NCC(
            $row['ID'],
            $row['TENNCC'],
            $row['SODIENTHOAI'],
            $row['MOTA'],
            $row['DIACHI'],
            $row['TRANGTHAIHD']
        );
    }

    public function readDatabase(): array
    {
        return $this->getAll();
    }
}
