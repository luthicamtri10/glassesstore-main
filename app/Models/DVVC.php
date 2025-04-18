<?php

namespace App\Models;

class DVVC
{
    private $Id, $tenDV, $moTa, $trangThaiHD;

    public function __construct($Id, $tenDV, $moTa, $trangThaiHD)
    {
        $this->Id = $Id;
        $this->tenDV = $tenDV;
        $this->moTa = $moTa;
        $this->trangThaiHD = $trangThaiHD;
    }

    // Getters
    public function getId()
    {
        return $this->Id;
    }

    public function getTenDV()
    {
        return $this->tenDV;
    }

    public function getMoTa()
    {
        return $this->moTa;
    }

    public function getTrangThaiHD()
    {
        return $this->trangThaiHD;
    }

    // Setters
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function setTenDV($tenDV)
    {
        $this->tenDV = $tenDV;
    }

    public function setMoTa($moTa)
    {
        $this->moTa = $moTa;
    }

    public function setTrangThaiHD($trangThaiHD)
    {
        $this->trangThaiHD = $trangThaiHD;
    }
}
