<?php
namespace App\Bus;

use App\Dao\CTQ_DAO;
use App\Dao\Tinh_DAO;
use App\Interface\BUSInterface;

use function Laravel\Prompts\error;

class CTQ_BUS implements BUSInterface{
    private $CTQList = array();
    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new CTQ_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->CTQList = CTQ_DAO::getInstance()->getAll();
    }
    public function getAllModels() : array
    {
        return $this->CTQList;
    }
    public function getModelById($id)
    {
        return CTQ_DAO::getInstance()->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a CTQ");
            return;
        }
        return CTQ_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a CTQ");
            return;
        } 
        return CTQ_DAO::getInstance()->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a CTQ");
            return;
        } 
        return CTQ_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = CTQ_DAO::getInstance()->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function deleteByIdQuyenAndIdChucNang($idQuyen, $idChucNang) {
        return CTQ_DAO::getInstance()->deleteByIdQuyenAndIdChucNang($idQuyen, $idChucNang);
    }
}
?>