<?php
namespace App\Bus;

use App\Dao\Tinh_DAO;
use App\Interface\BUSInterface;

use function Laravel\Prompts\error;

class Tinh_BUS implements BUSInterface{
    private $tinhList = array();
    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new Tinh_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->tinhList = Tinh_DAO::getInstance()->getAll();
    }
    public function getAllModels() : array
    {
        return $this->tinhList;
    }
    public function getModelById($id)
    {
        return Tinh_DAO::getInstance()->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a Tinh");
            return;
        }
        return Tinh_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a Tinh");
            return;
        } 
        return Tinh_DAO::getInstance()->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a Tinh");
            return;
        } 
        return Tinh_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = Tinh_DAO::getInstance()->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>