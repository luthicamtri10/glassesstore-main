<?php

namespace App\Models;
use JsonSerializable;

class CTHD implements JsonSerializable
{
    private $idHD, $giaLucDat, $trangThaiHD, $soSeri;

    public function __construct($idHD, $giaLucDat, $soSeri, $trangThaiHD)
    {
        $this->idHD = $idHD;
        $this->giaLucDat = $giaLucDat;
        $this->soSeri = $soSeri;
        $this->trangThaiHD = $trangThaiHD;
    }

    // Getter và Setter cho idHD
    public function getIdHD()
    {
        return $this->idHD;
    }

    public function setIdHD($idHD)
    {
        $this->idHD = $idHD;
    }


    // Getter và Setter cho giaLucDat
    public function getGiaLucDat()
    {
        return $this->giaLucDat;
    }

    public function setGiaLucDat($giaLucDat)
    {
        $this->giaLucDat = $giaLucDat;
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

    // Getter và Setter cho trangThaiHD
    public function getTrangThaiHD()
    {
        return $this->trangThaiHD;
    }

    public function setTrangThaiHD($trangThaiHD)
    {
        $this->trangThaiHD = $trangThaiHD;
    }

    public function jsonSerialize(): array {
        return [
            'IDHD' => $this->getIDHD(),
            'SOSERI' => $this->getSOSERI(),
            'GIALUCDAT' => $this->getGiaLucDat(),
            'TRANGTHAIBH' => $this->getTrangThaiHD(),
        ];
    }

}
