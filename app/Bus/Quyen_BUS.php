<?php
namespace App\Bus;

use App\Dao\Quyen_DAO;
use App\Interface\BUSInterface;
use App\Models\Quyen;

use function Laravel\Prompts\error;

class Quyen_BUS implements BUSInterface{
    private $quyenList = array();
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->quyenList = app(Quyen_DAO::class)->getAll();
    }
    public function getAllModels() : array
    {
        return $this->quyenList;
    }
    public function getModelById($id)
    {
        return app(Quyen_DAO::class)->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a Quyen");
            return;
        }
        return app(Quyen_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a Quyen");
            return;
        } 
        return app(Quyen_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a Quyen");
            return;
        } 
        return app(Quyen_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = app(Quyen_DAO::class)->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>