<?php
class CTSP_BUS {
    private $ctspDAO;

    public function __construct(CTSP_DAO $ctspDAO)
    {
        $this->ctspDAO = $ctspDAO;
    }

    public function addModel($model): int {
        return $this->ctspDAO->insert($model);
    }
}