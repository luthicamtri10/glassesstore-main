<?php
namespace App\Bus;
use App\Dao\CTSP_DAO;
class CTSP_BUS {
    private $ctspDAO;

    public function __construct(CTSP_DAO $ctspDAO)
    {
        $this->ctspDAO = $ctspDAO;
    }

    public function addModel($model): int {
        return $this->ctspDAO->insert($model);
    }
    public function getModelById($seri){
        return $this->ctspDAO->getById($seri);
    }
}