<?php
namespace App\Bus;

use App\Dao\Hang_DAO;
use App\Interface\BUSInterface;
use App\Models\Hang;

use function Laravel\Prompts\error;

class Hang_BUS implements BUSInterface {
    private $hangList = array();

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->hangList = app(Hang_DAO::class)->getAll();
    }

    public function getAllModels(): array {
        return $this->hangList;
    }

    public function getModelById($id) {
        return app(Hang_DAO::class)->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a Hang");
            return;
        }
        return app(Hang_DAO::class)->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a Hang");
            return;
        }
        return app(Hang_DAO::class)->update($model);
    }

    public function deleteModel($id) {
        if ($id == null || $id == "") {
            error("Error when deleting a Hang");
            return;
        }
        return app(Hang_DAO::class)->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = app(Hang_DAO::class)->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            error("No results found");
        }
        return null;
    }
}
?>
