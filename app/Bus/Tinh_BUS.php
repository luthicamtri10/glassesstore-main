<?php
namespace App\Bus;

use App\Dao\Tinh_DAO;
use App\Interface\BUSInterface;

use function Laravel\Prompts\error;

class Tinh_BUS implements BUSInterface{
    private $tinhList = array();
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->tinhList = app(Tinh_DAO::class)->getAll();
    }
    public function getAllModels() : array
    {
        return $this->tinhList;
    }
    public function getModelById($id)
    {
        return app(Tinh_DAO::class)->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a Tinh");
            return;
        }
        return app(Tinh_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a Tinh");
            return;
        } 
        return app(Tinh_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a Tinh");
            return;
        } 
        return app(Tinh_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = app(Tinh_DAO::class)->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>