<?php

namespace App\Models;

class CTGH
{
    private GioHang $ghModel;
    private CTSP $ctspModel;
    public function __construct(GioHang $ghModel, CTSP $ctspModel)
    {
        $this->ghModel = $ghModel;
        $this->ctspModel = $ctspModel;
        
    }
    // Getter cho ID
    public function getGioHang(): GioHang
    {
        return $this->ghModel;
    }

    // Setter cho ID
    public function setGioHang(GioHang $ghModel): void
    {
        $this->ghModel = $ghModel;
    }
    // Getter cho soSeri
    public function getCTSP(): CTSP
    {
        return $this->ctspModel;
    }

    // Setter cho soSeri
    public function setCTSP(CTSP $ctspModel): void
    {
        $this->ctspModel = $ctspModel;
    }
}