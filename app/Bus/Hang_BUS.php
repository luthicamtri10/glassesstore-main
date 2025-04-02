<?php
namespace App\Bus;

use App\Dao\Hang_DAO;
use App\Interface\BUSInterface;
use App\Models\Hang;

use function Laravel\Prompts\error;

class Hang_BUS implements BUSInterface {
    private $hangList = array();
    private $hangDAO;
    public function __construct(Hang_DAO $hang_dao) {
        $this->hangDAO = $hang_dao;
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->hangList = $this->hangDAO->getAll();
    }

    public function getAllModels(): array {
        return $this->hangList;
    }

    public function getModelById($id) {
        return $this->hangDAO->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a Hang");
            return;
        }
        return $this->hangDAO->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a Hang");
            return;
        }
        return $this->hangDAO->update($model);
    }

    public function deleteModel($id) {
        if ($id == null || $id == "") {
            error("Error when deleting a Hang");
            return;
        }
        return $this->hangDAO->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = $this->hangDAO->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            error("No results found");
        }
        return null;
    }
}
?>
