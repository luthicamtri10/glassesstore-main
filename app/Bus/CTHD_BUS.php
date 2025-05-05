<?php
namespace App\Bus;

use App\Dao\CTHD_DAO;

class CTHD_BUS {
    private $cthdDAO;

    public function __construct(CTHD_DAO $cthdDAO)
    {
        $this->cthdDAO = $cthdDAO;
    }

    public function addModel($model): int {
        return $this->cthdDAO->insert($model);
    }

    public function updateModel($model): int {
        return $this->cthdDAO->update($model);
    }

    public function getAllModels() {
        return $this->cthdDAO->readDatabase();
    }

    public function refreshData(): void {
        $this->cthdDAO->getAll();
     }

    public function getCTHTbyIDHD($id) {
        return $this->cthdDAO->getCTHDbyIDHD($id);
    }
}