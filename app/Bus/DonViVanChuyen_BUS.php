<?php
namespace App\Bus;

use App\Dao\DVVC_DAO;
use App\Interface\BUSInterface;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class DonViVanChuyen_BUS implements BUSInterface {
    private $dvvcList = array();
    private $dvvcDAO;

    public function __construct(DVVC_DAO $dvvcDAO) {
        $this->dvvcDAO = $dvvcDAO;
        $this->refreshData();
    }

    public function getAllModels() {
        return $this->dvvcList;
    }

    public function refreshData(): void {
        $this->dvvcList = $this->dvvcDAO->getAll();
    }


    public function getModelById(int $id) {
        return $this->dvvcDAO->getById($id);
    }

    public function addModel($model) {
        $validator = Validator::make($model->toArray(), [
            'tenDV' => 'required|string|max:255',
            'moTa' => 'required|string|max:255',
            'trangThaiHD' => 'required|string|max:255',
        ]);
        return $this->dvvcDAO->insert($model);
    }

    public function updateModel($model) {
        $validator = Validator::make([
            'tenDV' => $model->getTenDV(),
            'moTa' => $model->getMoTa(),
            'trangThaiHD' => $model->getTrangThaiHD()
        ], [
            'tenDV' => 'required|string|max:255',
            'moTa' => 'required|string|max:255',
            'trangThaiHD' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->dvvcDAO->update($model);
    }

    public function deleteModel(int $id) {
        return $this->dvvcDAO->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        return $this->dvvcDAO->search($value, $columns);
    }
}
?>
