<?php
namespace App\Bus;

use App\Dao\PTTT_DAO;
use App\Interface\BUSInterface;
use function Laravel\Prompts\error;

class PTTT_BUS implements BUSInterface {
    private $PTTTList = array();

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->PTTTList = app(PTTT_DAO::class)->getAll();
    }

    public function getAllModels(): array {
        return $this->PTTTList;
    }

    public function getModelById($id) {
        return app(PTTT_DAO::class)->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a PTTT");
            return;
        }
        return app(PTTT_DAO::class)->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a PTTT");
            return;
        }
        return app(PTTT_DAO::class)->update($model);
    }

    public function deleteModel($id) {
        if ($id == null || $id == "") {
            error("Error when deleting a PTTT");
            return;
        }
        return app(PTTT_DAO::class)->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = app(PTTT_DAO::class)->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>
