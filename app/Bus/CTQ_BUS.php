<?php
namespace App\Bus;

use App\Dao\CTQ_DAO;
use App\Dao\Tinh_DAO;
use App\Interface\BUSInterface;
use App\Models\CTQ;

use function Laravel\Prompts\error;

class CTQ_BUS implements BUSInterface{
    private $CTQList = array();
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->CTQList = app(CTQ_DAO::class)->getAll();
    }
    public function getAllModels() : array
    {
        return $this->CTQList;
    }
    public function getModelById($id)
    {
        return app(CTQ_DAO::class)->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a CTQ");
            return;
        }
        return app(CTQ_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a CTQ");
            return;
        } 
        return app(CTQ_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a CTQ");
            return;
        } 
        return app(CTQ_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = app(CTQ_DAO::class)->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function deleteByIdQuyenAndIdChucNang($idQuyen, $idChucNang) {
        return app(CTQ_DAO::class)->deleteByIdQuyenAndIdChucNang($idQuyen, $idChucNang);
    }
}
?>