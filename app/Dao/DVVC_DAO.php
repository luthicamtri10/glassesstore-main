<?php
namespace App\Dao;

use App\Interface\DAOInterface;
use App\Models\DVVC;
use App\Services\database_connection;
use Exception;
use InvalIDArgumentException;

use function Laravel\Prompts\alert;

class DVVC_DAO implements DAOInterface {
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DVVC_DAO();
        }
        return self::$instance;
    }

    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM DVVC");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createDVVCModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function createDVVCModel($rs) {
        $ID = $rs['ID'];
        $TENDV = $rs['TENDV'];
        $moTa = $rs['MOTA'];
        $trangThaiHD = $rs['TRANGTHAIHD'];
        return new DVVC($ID, $TENDV, $moTa, $trangThaiHD);
    }

    public function getAll(): array {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM DVVC");
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createDVVCModel($row);
            array_push($list, $model);
        }
        return $list;
    }

    public function getByID($ID) {
        $query = "SELECT * FROM DVVC WHERE ID = ?";
        $result = database_connection::executeQuery($query, $ID);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row) {
                return $this->createDVVCModel($row);
            }
        }
        return null;
    }

    public function insert($model): int {
        $query = "INSERT INTO DVVC (TENDV, moTa, trangThaiHD) VALUES (?, ? ,?)";
        $args = [$model->getTENDV(), $model->getMoTa(), $model->getTrangThaiHD()];
        return database_connection::executeQuery($query, ...$args);
    }

    public function update($model): int {
        $query = "UPDATE DVVC SET TENDV = ?, moTa = ?, trangThaiHD = ? WHERE ID = ?";
        $args = [$model->getTENDV(), $model->getMoTa(), $model->getTrangThaiHD(), $model->getID()];
        $result = database_connection::executeUpdate($query, ...$args);
        return is_int($result) ? $result : 0;
    }

    public function delete($ID): int {
        $query = "UPDATE DVVC SET trangThaiHD = false WHERE ID = ?";
        $result = database_connection::executeUpdate($query, ...[$ID]);
        return is_int($result) ? $result : 0;
    }

    public function search($value, $columns): array {
        if (empty($value)) {
            throw new InvalIDArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columns === null || count($columns) === 0) {
            $query = "SELECT * FROM DVVC WHERE ID LIKE ? OR TENDV LIKE ? OR moTa LIKE ? OR trangThaiHD LIKE ?";
            $args = array_fill(0, 4, "%" . $value . "%");
        } else if (count($columns) === 1) {
            $column = $columns[0];
            $query = "SELECT * FROM DVVC WHERE $column LIKE ?";
            $args = ["%" . $value . "%"];
        } else {
            $query = "SELECT * FROM DVVC WHERE " . implode(" LIKE ? OR ", $columns) . " LIKE ?";
            $args = array_fill(0, count($columns), "%" . $value . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $dvvcList = [];
        while ($row = $rs->fetch_assoc()) {
            $dvvcModel = $this->createDVVCModel($row);
            array_push($dvvcList, $dvvcModel);
        }
        if (count($dvvcList) === 0) {
            return [];
        }
        return $dvvcList;
    }
}
?>