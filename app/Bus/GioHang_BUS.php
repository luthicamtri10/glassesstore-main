<?php
namespace App\Bus;

use App\Dao\GioHang_DAO;
use App\Interface\BUSInterface;
use App\Models\GioHang;

class GioHang_BUS implements BUSInterface {
    private array $gioHangList = [];
    private GioHang_DAO $dao;
    public function __construct()
    {
        $this->dao = app(GioHang_DAO::class);
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->gioHangList = app(GioHang_BUS::class)->getAll();
    }
    public function getAllModels()
    {
        return $this->gioHangList;
    }
    public function getModelById($id)
    {
        return app(GioHang_DAO::class)->getById($id);
    }
    public function addModel($model)
    {
        if($model == null) {
            error_log("Error when insert a GioHang");
            return;
        }
        return app(GioHang_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error_log("Error when update a GioHang");
            return;
        }
        return app(GioHang_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error_log("Error when delete a GioHang");
            return;
        }
        return app(GioHang_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        return app(GioHang_DAO::class)->search($value, $columns);
    }
}
?>