<?php
namespace App\Bus;

use App\Dao\NguoiDung_DAO;
use App\Interface\BUSInterface;
use App\Models\NguoiDung;

class NguoiDung_BUS implements BUSInterface {
    private $nguoiDungList = array();
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->nguoiDungList = app(NguoiDung_DAO::class)->getAll();
    }
    public function getAllModels()
    {
        return $this->nguoiDungList;
    }
    public function getModelById($id)
    {
        return app(NguoiDung_DAO::class)->getById($id);
    }
    public function addModel($model)
    {
        if($model == null) {
            error_log("Error when insert a NguoiDung");
            return;
        }
        return app(NguoiDung_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error_log("Error when update a NguoiDung");
            return;
        }
        return app(NguoiDung_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error_log("Error when delete a NguoiDung");
            return;
        }
        return app(NguoiDung_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        return app(NguoiDung_DAO::class)->search($value, $columns);
    }
}
?>