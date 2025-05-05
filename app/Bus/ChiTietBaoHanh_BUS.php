<?php

namespace App\Bus;

use App\Dao\ChiTietBaoHanh_DAO;
use App\Interface\BUSInterface;
use App\Models\ChiTietBaoHanh;
use InvalidArgumentException;

class ChiTietBaoHanh_BUS implements BUSInterface
{
    private array $chiTietBaoHanhList = [];
    private ChiTietBaoHanh_DAO $dao;

    public function __construct()
    {
        $this->dao = app(ChiTietBaoHanh_DAO::class);
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $this->chiTietBaoHanhList = $this->dao->getAll();
    }

    public function getAllModels(): array
    {
        return $this->chiTietBaoHanhList;
    }

    public function getModelById($id): ?ChiTietBaoHanh
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa 'idKhachHang' và 'soSeri'");
        }

        return $this->dao->getByIdKHAndSoSeri($id['idKhachHang'], $id['soSeri']);
    }

    public function addModel($model): int
    {
        if (!$model instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Model phải là instance của ChiTietBaoHanh");
        }

        $result = $this->dao->insert($model);
        if ($result > 0) {
            $this->refreshData();
        }
        return $result;
    }

    public function updateModel($model): int
    {
        if (!$model instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Model phải là instance của ChiTietBaoHanh");
        }

        $result = $this->dao->update($model);
        if ($result > 0) {
            $this->refreshData();
        }
        return $result;
    }

    public function deleteModel($id): int
    {
        if (!is_array($id) || !isset($id['soSeri'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa khóa 'soSeri'");
        }

        $result = $this->dao->delete($id['soSeri']);
        if ($result > 0) {
            $this->refreshData();
        }
        return $result;
    }

    public function searchModel(string $value, array $columns): array
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Giá trị tìm kiếm không được để trống");
        }

        return $this->dao->search($value, $columns);
    }
}
