<?php
namespace App\Bus;

use App\Dao\NguoiDung_DAO;
use App\Interface\BUSInterface;
use App\Models\NguoiDung;

class NguoiDung_BUS{
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
    public function controlDeleteModel($id, $active)
    {
        if($id == null || $id == "") {
            error_log("Error when delete a NguoiDung");
            return;
        }
        return $this->nguoiDungDAO->controlDelete($id, $active);
    }
    public function searchModel(string $value, array $columns)
    {
        return $this->nguoiDungDAO->search($value, $columns);
    }
    public function searchByTinh($idTinh) {
        return $this->nguoiDungDAO->searchByTinh($idTinh);
    }
    public function checkExistingUser($sdt) {
        foreach($this->nguoiDungList as $it) {
            if($it->getgetSoDienThoai() == $sdt) {
                return true;
            }
        }
        return false;
    }
    public function getModelBySDT($sdt) {
        return $this->nguoiDungDAO->getBySDT($sdt);
    }
 }
?>