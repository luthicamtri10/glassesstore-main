<?php
namespace App\Bus;

use App\Dao\Quyen_DAO;
use App\Interface\BUSInterface;
use App\Models\Quyen;

use function Laravel\Prompts\error;

class Quyen_BUS implements BUSInterface{
    private $quyenList = array();
    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new Quyen_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->quyenList = Quyen_DAO::getInstance()->getAll();
    }
    public function getAllModels() : array
    {
        return $this->quyenList;
    }
    public function getModelById($id)
    {
        return Quyen_DAO::getInstance()->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a Quyen");
            return;
        }
        return Quyen_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a Quyen");
            return;
        } 
        return Quyen_DAO::getInstance()->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a Quyen");
            return;
        } 
        return Quyen_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = Quyen_DAO::getInstance()->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>