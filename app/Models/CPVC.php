<?php

namespace App\Models;

class CPVC
{
    private $idTinh, $idVC, $chiPhiVC;

    public function __construct($idTinh, $idVC, $chiPhiVC)
    {
        $this->idTinh = $idTinh;
        $this->idVC = $idVC;
        $this->chiPhiVC = $chiPhiVC;
    }

    // Getters
    public function getIdTinh()
    {
        return $this->idTinh;
    }

    public function getIdVC()
    {
        return $this->idVC;
    }

    public function getChiPhiVC()
    {
        return $this->chiPhiVC;
    }

    // Setters
    public function setIdTinh($idTinh)
    {
        $this->idTinh = $idTinh;
    }

    public function setIdVC($idVC)
    {
        $this->idVC = $idVC;
    }

    public function setChiPhiVC($chiPhiVC)
    {
        $this->chiPhiVC = $chiPhiVC;
    }
}
