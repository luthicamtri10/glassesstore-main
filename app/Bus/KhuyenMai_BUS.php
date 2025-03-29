<?php
namespace App\Bus;

use App\Dao\KhuyenMai_DAO;
use App\Interface\BUSInterface;
use App\Models\KhuyenMai;

use function Laravel\Prompts\error;

class KhuyenMai_BUS implements BUSInterface {
    private $khuyenMaiList = array();

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->khuyenMaiList = app(KhuyenMai_DAO::class)->getAll();
    }

    public function getAllModels(): array {
        return $this->khuyenMaiList;
    }

    public function getModelById($id) {
        return app(KhuyenMai_DAO::class)->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a Khuyen Mai");
            return;
        }
        return app(KhuyenMai_DAO::class)->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a Khuyen Mai");
            return;
        }
        return app(KhuyenMai_DAO::class)->update($model);
    }

    public function deleteModel($id) {
        if ($id == null || $id == "") {
            error("Error when deleting a Khuyen Mai");
            return;
        }
        return app(KhuyenMai_DAO::class)->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = app(KhuyenMai_DAO::class)->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>
