<?php
namespace App\Bus;

use App\Dao\NCC_DAO;
use App\Interface\BUSInterface;

class NCC_BUS implements BUSInterface {
    private $NCCList = array();
    private static $instance;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new NCC_BUS();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->NCCList = NCC_DAO::getInstance()->getAll();
    }

    public function getAllModels(): array {
        return $this->NCCList;
    }

    public function getModelById(int $id) {
        return NCC_DAO::getInstance()->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            throw new \InvalidArgumentException("Error when adding an NCC");
        }
        return NCC_DAO::getInstance()->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            throw new \InvalidArgumentException("Error when updating an NCC");
        }
        return NCC_DAO::getInstance()->update($model);
    }

    public function deleteModel(int $id) {
        if ($id == null || $id == "") {
            throw new \InvalidArgumentException("Error when deleting an NCC");
        }
        return NCC_DAO::getInstance()->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = NCC_DAO::getInstance()->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            return null;
        }
    }
}
