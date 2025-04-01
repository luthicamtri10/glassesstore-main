<?php

namespace App\Models;

class CTPN
{
    private $idPN, $idSP, $soLuong, $giaNhap, $phanTramLN;

    public function __construct($idPN, $idSP, $soLuong, $giaNhap, $phanTramLN)
    {
        $this->idPN = $idPN;
        $this->idSP = $idSP;
        $this->soLuong = $soLuong;
        $this->giaNhap = $giaNhap;
        $this->phanTramLN = $phanTramLN;
    }

    // Getters
    public function getIdPN()
    {
        return $this->idPN;
    }

    public function getIdSP()
    {
        return $this->idSP;
    }

    public function getSoLuong()
    {
        return $this->soLuong;
    }

    public function getGiaNhap()
    {
        return $this->giaNhap;
    }

    public function getPhanTramLN()
    {
        return $this->phanTramLN;
    }

    // Setters
    public function setIdPN($idPN)
    {
        $this->idPN = $idPN;
    }

    public function setIdSP($idSP)
    {
        $this->idSP = $idSP;
    }

    public function setSoLuong($soLuong)
    {
        $this->soLuong = $soLuong;
    }

    public function setGiaNhap($giaNhap)
    {
        $this->giaNhap = $giaNhap;
    }

    public function setPhanTramLN($phanTramLN)
    {
        $this->phanTramLN = $phanTramLN;
    }
}
