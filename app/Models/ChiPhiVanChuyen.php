<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiPhiVanChuyen extends Model {
    use HasFactory;

    protected $table = 'chiphivanchuyen';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'IDTINH',
        'IDVC',
        'CHIPHIVC'
    ];
} 