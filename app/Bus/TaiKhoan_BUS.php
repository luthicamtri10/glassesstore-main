<?php
namespace App\Bus;

use App\Dao\TaiKhoan_DAO;
use App\Interface\BUSInterface;

use function Laravel\Prompts\error;

class TaiKhoan_BUS implements BUSInterface{
    private $taiKhoanList = array();
    private static $instance;
    public static function getInstance () {
        if(self::$instance == null) {
            self::$instance = new TaiKhoan_BUS();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->taiKhoanList = TaiKhoan_DAO::getInstance()->getAll();
    }
    public function getAllModels() : array
    {
        return $this->taiKhoanList;
    }
    public function getModelById($id)
    {
        return TaiKhoan_DAO::getInstance()->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a TaiKhoan");
            return;
        }
        return TaiKhoan_DAO::getInstance()->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a TaiKhoan");
            return;
        } 
        return TaiKhoan_DAO::getInstance()->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a TaiKhoan");
            return;
        } 
        return TaiKhoan_DAO::getInstance()->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = TaiKhoan_DAO::getInstance()->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function checkLogin($email, $password) : bool {
        return TaiKhoan_DAO::getInstance()->checkLogin($email, $password);
    }
    public function login($email, $password) {
        return TaiKhoan_DAO::getInstance()->login($email, $password);
    }
    public function logout() {
        return TaiKhoan_DAO::getInstance()->logout();
    }
}
?>