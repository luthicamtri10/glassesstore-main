<?php
namespace App\Bus;

use App\Dao\LoaiSanPham_DAO;
use App\Interface\BUSInterface;
use function Laravel\Prompts\error;

class LoaiSanPham_BUS implements BUSInterface {
    private $LoaiSanPhamList = array();

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->LoaiSanPhamList = app(LoaiSanPham_DAO::class)->getAll();
    }

    public function getAllModels(): array {
        return $this->LoaiSanPhamList;
    }

    public function getModelById($id) {
        return app(LoaiSanPham_DAO::class)->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a LoaiSanPham");
            return;
        }
        return app(LoaiSanPham_DAO::class)->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a LoaiSanPham");
            return;
        }
        return app(LoaiSanPham_DAO::class)->update($model);
    }

    public function deleteModel($id) {
        if ($id == null || $id == "") {
            error("Error when deleting a LoaiSanPham");
            return;
        }
        return app(LoaiSanPham_DAO::class)->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = app(LoaiSanPham_DAO::class)->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>
