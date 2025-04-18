<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonViVanChuyen extends Model
{
    use HasFactory;

    protected $table = 'donvivanchuyen';
    protected $primaryKey = 'IDDVVC';
    public $timestamps = false;

    protected $fillable = [
        'TENDV',
        'MOTA',
        'TRANGTHAIHD'
    ];

    public function getTENDV()
    {
        return $this->TENDV;
    }

    public function getMoTa()
    {
        return $this->MOTA;
    }

    public function getTrangThaiHD()
    {
        return $this->TRANGTHAIHD;
    }
} 