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
        $query = "SELECT * FROM NCC WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->createNCCModel($row);
        }
        return null;
    }

    public function insert($model): int
    {
        $query = "INSERT INTO NCC (tenNCC, sdtNCC, diachi, trangthaiHD) VALUES (?, ?, ?, ?)";
        $args = [$model->getTenNCC(), $model->getSdtNCC(), $model->getDiachi(), $model->getTrangthaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function update($model): int
    {
        $query = "UPDATE NCC SET tenNCC = ?, sdtNCC = ?, diachi = ?, trangthaiHD = ? WHERE id = ?";
        $args = [$model->getTenNCC(), $model->getSdtNCC(), $model->getDiachi(), $model->getTrangthaiHD(), $model->getIdNCC()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function delete($id): int
    {
        $query = "DELETE FROM NCC WHERE id = ?";
        return database_connection::executeQuery($query, $id);
    }

    public function search($keyword, array $columnNames): array
    {
        $list = [];
        $conditions = implode(" OR ", array_map(fn($col) => "$col LIKE ?", $columnNames));
        $query = "SELECT * FROM NCC WHERE $conditions";
        $params = array_fill(0, count($columnNames), "%$keyword%");
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
