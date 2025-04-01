<?php
namespace App\Bus;

use App\Dao\NguoiDung_DAO;
use App\Interface\BUSInterface;
use App\Models\NguoiDung;

class NguoiDung_BUS implements BUSInterface {
    private $nguoiDungList = array();
    private $nguoiDungDAO;
    public function __construct(NguoiDung_DAO $nguoi_dung_dao)
    {
        $this->nguoiDungDAO = $nguoi_dung_dao;
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->nguoiDungList = $this->nguoiDungDAO->getAll();
    }
    public function getAllModels()
    {
        return $this->nguoiDungList;
    }
    public function getModelById($id)
    {
        return $this->nguoiDungDAO->getById($id);
    }
    public function addModel($model)
    {
        if($model == null) {
            error_log("Error when insert a NguoiDung");
            return;
        }
        return $this->nguoiDungDAO->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error_log("Error when update a NguoiDung");
            return;
        }
        return $this->nguoiDungDAO->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error_log("Error when delete a NguoiDung");
            return;
        }
        return $this->nguoiDungDAO->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        return $this->nguoiDungDAO->search($value, $columns);
    }
}
?>