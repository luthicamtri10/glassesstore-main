<?php
namespace App\Bus;

use App\Dao\GioHang_DAO;
use App\Interface\BUSInterface;
use App\Models\GioHang;
use InvalidArgumentException;


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
        if (!is_array($id) || !isset($id['enail'])|| !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa enail và soSeri");
        }
        return app(GioHang_DAO::class)->getById($id);
    }
    public function addModel($model)
    {
        if (!$model instanceof GioHang) {
            throw new InvalidArgumentException("Model phải là instance của GioHang");
        }

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
        if (empty($value)) {
            throw new InvalidArgumentException("Giá trị tìm kiếm không được để trống");
        }

        return app(GioHang_DAO::class)->search($value, $columns);
    }
}
?>