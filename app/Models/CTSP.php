<?php

namespace App\Models;

class CTSP
{
    private SanPham $idSP;
    private $soSeri;

    public function __construct(SanPham $idSP, $soSeri)
    {
        $this->idSP = $idSP;
        $this->soSeri = $soSeri;
    }

    // Getter và Setter cho ID
    public function getIdSP() : SanPham
    {
        return $this->idSP;
    }

    public function setIdSP(SanPham $idSP)
    {
        $this->idSP = $idSP;
    }

    // Getter và Setter cho soSeri
    public function getSoSeri()
    {
        return $this->soSeri;
    }

    public function setSoSeri($soSeri)
    {
        $this->soSeri = $soSeri;
    }
}
