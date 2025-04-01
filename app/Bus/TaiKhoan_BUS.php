<?php
namespace App\Bus;

use App\Dao\TaiKhoan_DAO;
use App\Interface\BUSInterface;

use function Laravel\Prompts\error;

class TaiKhoan_BUS implements BUSInterface{
    private $taiKhoanList = array();
    
    public function __construct()
    {
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->taiKhoanList = app(TaiKhoan_DAO::class)->getAll();
    }
    public function getAllModels() : array
    {
        return $this->taiKhoanList;
    }
    public function getModelById($id)
    {
        return app(TaiKhoan_DAO::class)->getById($id);    }
    public function addModel($model)
    {
        if($model == null) {
            error("Error when add a TaiKhoan");
            return;
        }
        return app(TaiKhoan_DAO::class)->insert($model);
    }
    public function updateModel($model)
    {
        if($model == null) {
            error("Error when update a TaiKhoan");
            return;
        } 
        return app(TaiKhoan_DAO::class)->update($model);
    }
    public function deleteModel($id)
    {
        if($id == null || $id == "") {
            error("Error when delete a TaiKhoan");
            return;
        } 
        return app(TaiKhoan_DAO::class)->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = app(TaiKhoan_DAO::class)->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function checkLogin($email, $password) : bool {
        return app(TaiKhoan_DAO::class)->checkLogin($email, $password);
    }
    public function login($email, $password) {
        return app(TaiKhoan_DAO::class)->login($email, $password);
    }
    public function logout() {
        return app(TaiKhoan_DAO::class)->logout();
    }
}
?>