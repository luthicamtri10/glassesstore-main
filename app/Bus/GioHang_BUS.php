<?php
namespace App\Bus;

use App\Dao\GioHang_DAO;
use App\Interface\BUSInterface;
use App\Models\GioHang;
use InvalidArgumentException;


class GioHang_BUS  {
    private array $gioHangList = [];
    private GioHang_DAO $gioHangDAO;
    public function __construct(GioHang_DAO $gio_hang_dao)
    {
        $this->gioHangDAO = $gio_hang_dao;
        $this->refreshData();
    }
    public function refreshData(): void
    {
        $this->gioHangList = $this->gioHangDAO->getAll();
    }
    public function getAllModels()
    {
        return $this->gioHangList;
    }
    public function getModelById($id)
    {
        return $this->gioHangDAO->getById($id);
    }
    public function getByEmail($email)
    {
        return $this->gioHangDAO->getByEmail($email);
    }
    public function addModel($model)
    {
        
        return $this->gioHangDAO->insert($model);
    }
    public function updateModel($model)
    {
        return $this->gioHangDAO->update($model);
    }
    public function controlDeleteModel($id,$active)
    {
       
        return $this->gioHangDAO->controlDeleteModel($id,$active);
    }
    public function searchModel(string $value, array $columns)
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Giá trị tìm kiếm không được để trống");
        }

        return app(GioHang_DAO::class)->search($value, $columns);
    }
}
?>