<?php
namespace App\Bus;

use App\Dao\ChucNang_DAO;
use App\Interface\BUSInterface;
use PhpParser\Node\Stmt\Echo_;

use function Laravel\Prompts\error;

class ChucNang_BUS implements BUSInterface{
    private $ChucNangList = array();
    private $StaticList = array();
    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new ChucNang_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->ChucNangList = ChucNang_DAO::getInstance()->getAll();
    }
    public function getAllModels() : array
    {
        return $this->ChucNangList;
    }
    public function getModelById(int $id)
    {
        return ChucNang_DAO::getInstance()->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a ChucNang");
            return;
        }
        return ChucNang_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a ChucNang");
            return;
        } 
        return ChucNang_DAO::getInstance()->update($model);
    }
    public function deleteModel(int $id)
    {
        if($id == null || $id == "") {
            error("Error when delete a ChucNang");
            return;
        } 
        return ChucNang_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = ChucNang_DAO::getInstance()->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>