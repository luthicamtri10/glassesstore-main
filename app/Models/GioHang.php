<?php

namespace App\Models;

class GioHang
{
    private String $email;
    private int $id, $trangThaiHD;
    private string $createdAt;


    public function __construct(int $id, String $email, string $createdAt, int $trangThaiHD)
    {
        $this->id = $id;
        $this->email = $email;
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
    public function getEmail(): String
    {
        return $this->email;
    }

    // Setter cho tk
    public function setEmail(String $email): void
    {
        $this->email = $email;
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