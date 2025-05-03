<?php
namespace App\Bus;
use Illuminate\Support\Facades\Validator;
use App\Dao\CPVC_DAO;
use App\Interface\BUSInterface;

class CPVC_BUS implements BUSInterface
{
    private $CPVCList = array();
    private $cpvcDAO;

  
    public function __construct(CPVC_DAO $cpvcDAO)
    {
        $this->cpvcDAO = $cpvcDAO;
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $this->CPVCList = $this->cpvcDAO->getAll();
    }

    public function getAllModels(): array
    {
        return $this->CPVCList;
    }


    public function getModelById(int $id)
    {
        return $this->cpvcDAO->getById($id);
    }

    public function addModel($model)
    {
        if ($model == null) {
            throw new \InvalidArgumentException("Error when adding a CPVC record.");
        }

        $validator = Validator::make([
            'IDTINH' => $model->getIDTINH(),
            'IDVC' => $model->getIDVC(),
            'CHIPHIVC' => $model->getCHIPHIVC()
        ], [
            'IDTINH' => 'required|integer',
            'IDVC' => 'required|integer',
            'CHIPHIVC' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->cpvcDAO->insert($model);
    }

    public function updateModel($model)
    {
        if ($model == null) {
            throw new \InvalidArgumentException("Error when updating a CPVC record.");
        }

        $validator = Validator::make([
            'IDTINH' => $model->getIDTINH(),
            'IDVC' => $model->getIDVC(),
            'CHIPHIVC' => $model->getCHIPHIVC()
        ], [
            'IDTINH' => 'required|integer',
            'IDVC' => 'required|integer',
            'CHIPHIVC' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->cpvcDAO->update($model);
    }

    public function deleteModel(int $id)
    {
        if ($id == null || $id == "") {
            throw new \InvalidArgumentException("Error when deleting a CPVC record.");
        }
        return $this->cpvcDAO->delete($id);
    }

    public function searchModel(string $value, array $columns)
    {
        return $this->cpvcDAO->search($value, $columns);
    }

    public function search(string $keyword): array
    {
        try {
            $columns = ['IDTINH', 'IDVC', 'CHIPHIVC'];
            return $this->searchModel($keyword, $columns) ?? [];
        } catch (\Exception $e) {
            error_log("Error searching shipping costs: " . $e->getMessage());
            return [];
        }
    }
} 