<?php

namespace App\Models;

class GioHang
{
    private TaiKhoan $tkModel;
    private int $id, $trangThaiHD;
    private string $createdAt;


    public function __construct(int $id, TaiKhoan $tkModel, string $createdAt, int $trangThaiHD)
    {
        $this->id = $id;
        $this->tkModel = $tkModel;
        $this->createdAt = $createdAt;
        $this->trangThaiHD = $trangThaiHD;
    }

    // Getter cho ID
    public function getId(): int
    {
        return $this->id;
    }

    // Setter cho ID
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter cho tk
    public function getTaiKhoan(): TaiKhoan
    {
        return $this->tkModel;
    }

    // Setter cho tk
    public function setTaiKhoan(TaiKhoan $tkModel): void
    {
        $this->tkModel = $tkModel;
    }

    // Getter cho CREATEDAT
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    // Setter cho CREATEDAT
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    // Getter cho TRANGTHAIID
    public function getTrangThaiHD(): int
    {
        return $this->trangThaiHD;
    }

    // Setter cho TRANGTHAIID
    public function setTrangThaiHD(int $trangThaiHD): void
    {
        $this->trangThaiHD = $trangThaiHD;
    }
}
