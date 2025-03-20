<?php
namespace App\Bus;

use App\Dao\NguoiDung_DAO;
use App\Interface\BUSInterface;
use App\Models\NguoiDung;

class NguoiDung_BUS implements BUSInterface {
    private static $instance;
    private $nguoiDungList = array();
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new NguoiDung_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->nguoiDungList = NguoiDung_DAO::getInstance()->getAll();
    }
    public function getAllModels()
    {
        return $this->nguoiDungList;
    }
    public function getModelById($id)
    {
        return NguoiDung_DAO::getInstance()->getById($id);
    }
    public function addModel($model)
    {
        if($model == null) {
            error_log("Error when insert a NguoiDung");
            return;
        }
        return NguoiDung_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error_log("Error when update a NguoiDung");
            return;
        }
        return NguoiDung_DAO::getInstance()->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error_log("Error when delete a NguoiDung");
            return;
        }
        return NguoiDung_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        return NguoiDung_DAO::getInstance()->search($value, $columns);
    }
}
?>