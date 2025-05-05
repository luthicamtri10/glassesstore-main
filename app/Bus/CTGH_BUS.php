<?php

namespace App\Bus;

use App\Dao\CTGH_DAO;
use App\Models\CTGH;

class CTGH_BUS {
    protected $dao;

    public function __construct(CTGH_DAO $dao) {
        $this->dao = $dao;
    }

    public function getByIDGH($idgh) {
        return $this->dao->getByIDGH($idgh);
    }

    public function addCTGH(CTGH $model) {
        return $this->dao->addCTGH($model);
    }

    public function deleteCTGH($idgh, $idsp) {
        return $this->dao->deleteCTGH($idgh, $idsp);
    }

    public function getCTGHByIDGHAndIDSP($idGH, $idSP) {
        return $this->dao->getCTGHByIDGHAndIDSP($idGH, $idSP);
    }

    public function updateCTGH(CTGH $model) {
        return $this->dao->updateCTGH($model);
    }

    // public function searchCTGHByKeyword($idgh, $keyword) {
    //     // Thêm dấu % để LIKE hoạt động chính xác
    //     $keyword = '%' . $keyword . '%';
    //     return $this->dao->searchCTGHByKeyword($idgh, $keyword);
    // }
}
