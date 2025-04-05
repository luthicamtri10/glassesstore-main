<?php
namespace App\Bus;
use App\Dao\HoaDon_DAO;

use App\Interface\BUSInterface;
use Illuminate\Support\Facades\Validator;
class HoaDon_BUS{

    private $hoaDonDAO;

    public function __construct(HoaDon_DAO $hoaDonDAO)
    {
        $this->hoaDonDAO = $hoaDonDAO;
    }

    public function getAllModels() {
        return $this->hoaDonDAO->readDatabase();
    }

    public function refreshData(): void {
       $this->hoaDonDAO->getAll();
    }

    public function getModelById(int $id) {
        $models = $this->hoaDonDAO->readDatabase();
        foreach ($models as $model) {
            if ($model->getId() === $id) {
                return $model;
            }
        }
        return null;
    }

    public function addModel($model): int {  
        return $this->hoaDonDAO->insert($model);
    }

    public function updateModel($model): int {
        return $this->hoaDonDAO->update($model);
    }

    public function searchModel(string $value, array $columns): array {
        return $this->hoaDonDAO->search($value, $columns);
    }

}