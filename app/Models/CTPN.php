<?php

namespace App\Models;

class CTPN
{
    private $idPN, $idSP, $soLuong, $giaNhap, $phanTramLN, $donGia;
    private $sanPham;

    public function __construct($idPN, $idSP, $soLuong, $giaNhap, $phanTramLN)
    {
        $this->idPN = $idPN;
        $this->idSP = $idSP;
        $this->soLuong = $soLuong;
        $this->giaNhap = $giaNhap;
        $this->phanTramLN = $phanTramLN;
        $this->donGia = $giaNhap; // Initialize donGia with giaNhap
        $this->sanPham = null; // Initialize sanPham as null
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

    public function getDonGia(): float
    {
        return (float)$this->donGia;
    }

    public function getSanPham()
    {
        return $this->sanPham;
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
        $this->donGia = $giaNhap; // Update donGia when giaNhap changes
    }

    public function setPhanTramLN($phanTramLN)
    {
        $this->phanTramLN = $phanTramLN;
    }

    public function setDonGia(float $donGia): void
    {
        $this->donGia = $donGia;
    }

    public function setSanPham($sanPham)
    {
        $this->sanPham = $sanPham;
    }
}
    


