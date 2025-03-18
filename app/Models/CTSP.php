<?php

namespace App\Models;

class CTSP
{
    private $idSP, $soSeri;

    public function __construct($idSP, $soSeri)
    {
        $this->idSP = $idSP;
        $this->soSeri = $soSeri;
    }

    // Getter và Setter cho ID
    public function getIdSP()
    {
        return $this->idSP;
    }

    public function setIdSP($idSP)
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
