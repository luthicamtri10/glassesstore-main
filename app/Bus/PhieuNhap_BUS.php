<?php
namespace App\Bus;
use App\Dao\PhieuNhap_DAO;
use App\Interface\BUSInterface;


class PhieuNhap_BUS implements BUSInterface
{
    private $phieuNhapList = array();
    private $phieuNhapDAO;
    public function __construct(PhieuNhap_DAO $phieu_nhap_dao)
    {
        $this->phieuNhapDAO = $phieu_nhap_dao;
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->phieuNhapList = $this->phieuNhapDAO->getAll();
    }
   
    public function getAllModels()
    {
        return $this->phieuNhapList;
    }
    public function getModelById($id)
    {
        return $this->phieuNhapDAO->getById($id);    }
    public function addModel($model)
    {
        return $this->phieuNhapDAO->insert($model);
    }
    public function updateModel($model)
    {
        return $this->phieuNhapDAO->update($model);
    }
    public function deleteModel($id)
    {
        
        return $this->phieuNhapDAO->delete($id);
    }
    public function searchModel(string $value, array $columns)
    {
        $list = $this->phieuNhapDAO->search($value, $columns);
        if(count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function getLastPN(){
        return $this->phieuNhapDAO->getLastPN();
    }
}
?>