<?php

namespace App\Models;

class SanPham
{
    private $id, $tenSanPham;
    private Hang $idHang;
    private LoaiSanPham $idLSP;
    private $moTa, $donGia, $thoiGianBaoHanh, $trangThaiHD;

    public function __construct($id = null, $tenSanPham,Hang $idHang,LoaiSanPham $idLSP, $moTa, $donGia, $thoiGianBaoHanh, $trangThaiHD)
    {
        $this->id = $id;
        $this->tenSanPham = $tenSanPham;
        $this->idHang = $idHang;
        $this->idLSP = $idLSP;
        $this->moTa = $moTa;
        $this->donGia = $donGia;
        $this->thoiGianBaoHanh = $thoiGianBaoHanh;
        $this->trangThaiHD = $trangThaiHD;
    }

    // Getter và Setter cho ID
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter và Setter cho tenSanPham
    public function getTenSanPham()
    {
        return $this->tenSanPham;
    }

    public function setTenSanPham($tenSanPham)
    {
        $this->tenSanPham = $tenSanPham;
    }

    // Getter và Setter cho idHang
    public function getIdHang() : Hang
    {
        return $this->idHang;
    }

    public function setIdHang(Hang $idHang)
    {
        $this->idHang = $idHang;
    }

    // Getter và Setter cho idLSP
    public function getIdLSP() : LoaiSanPham
    {
        return $this->idLSP;
    }

    public function setIdLSP(LoaiSanPham $idLSP)
    {
        $this->idLSP = $idLSP;
    }


    // Getter và Setter cho moTa
    public function getMoTa()
    {
        return $this->moTa;
    }

    public function setMoTa($moTa)
    {
        $this->moTa = $moTa;
    }

    // Getter và Setter cho donGia
    public function getDonGia()
    {
        return $this->donGia;
    }

    public function setDonGia($donGia)
    {
        $this->donGia = $donGia;
    }

    // Getter và Setter cho thoiGianBaoHanh
    public function getThoiGianBaoHanh()
    {
        return $this->thoiGianBaoHanh;
    }

    public function setThoiGianBaoHanh($thoiGianBaoHanh)
    {
        $this->thoiGianBaoHanh = $thoiGianBaoHanh;
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
