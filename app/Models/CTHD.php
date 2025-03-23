<?php

namespace App\Models;

class CTHD
{
    private $idHD, $idSP, $soLuong, $giaLucDat, $trangThaiHD, $soSeri;

    public function __construct($idHD, $idSP, $soLuong, $giaLucDat, $soSeri, $trangThaiHD)
    {
        $this->idHD = $idHD;
        $this->idSP = $idSP;
        $this->soLuong = $soLuong;
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

    // Getter và Setter cho idSP
    public function getIdSP()
    {
        return $this->idSP;
    }

    public function setIdSP($idSP)
    {
        $this->idSP = $idSP;
    }

    // Getter và Setter cho soLuong
    public function getSoLuong()
    {
        return $this->soLuong;
    }

    public function setSoLuong($soLuong)
    {
        $this->soLuong = $soLuong;
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


}
