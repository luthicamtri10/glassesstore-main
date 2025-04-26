<?php

namespace App\Models;

use App\Enum\HoaDonEnum;

class HoaDon
{
    private $id, $tongTien, $ngayTao, $idDVVC;
    private TaiKhoan $email;
    private NguoiDung $idNhanVien;
    private PTTT $idPTTT;
    private HoaDonEnum $trangThai;

    public function __construct($id = null, $email, $idNhanVien, $tongTien, $idPTTT, $ngayTao, $idDVVC,HoaDonEnum $trangThai)
    {
        $this->id = $id;
        $this->email = $email;
        $this->idNhanVien = $idNhanVien;
        $this->tongTien = $tongTien;
        $this->idPTTT = $idPTTT;
        $this->ngayTao = $ngayTao;
        $this->idDVVC = $idDVVC;
        $this->trangThai = $trangThai;
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
 
     // Getter và Setter cho idKhachHang
     public function getEmail()
     {
         return $this->email;
     }
 
     public function setEmail($email)
     {
         $this->email = $email;
     }
 
     // Getter và Setter cho idNhanVien
     public function getIdNhanVien()
     {
         return $this->idNhanVien;
     }
 
     public function setIdNhanVien($idNhanVien)
     {
         $this->idNhanVien = $idNhanVien;
     }
 
     // Getter và Setter cho tongTien
     public function getTongTien()
     {
         return $this->tongTien;
     }
 
     public function setTongTien($tongTien)
     {
         $this->tongTien = $tongTien;
     }
 
     // Getter và Setter cho idPTTT
     public function getIdPTTT()
     {
         return $this->idPTTT;
     }
 
     public function setIdPTTT($idPTTT)
     {
         $this->idPTTT = $idPTTT;
     }
 
     // Getter và Setter cho ngayTao
     public function getNgayTao()
     {
         return $this->ngayTao;
     }
 
     public function setNgayTao($ngayTao)
     {
         $this->ngayTao = $ngayTao;
     }
 
     // Getter và Setter cho idDVVC
     public function getIdDVVC()
     {
         return $this->idDVVC;
     }
 
     public function setIdDVVC($idDVVC)
     {
         $this->idDVVC = $idDVVC;
     }
 
     // Getter và Setter cho trangThai
     public function getTrangThai()
     {
         return $this->trangThai;
     }
 
     public function setTrangThai(HoaDonEnum $trangThai)
     {
         $this->trangThai = $trangThai;
     }

}
