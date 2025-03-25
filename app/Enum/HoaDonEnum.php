<?php
namespace App\Enum;
enum HoaDonEnum : String
{
    case PENDING = 'PENDING';
    case PAID = 'PAID';
    case EXPIRED = 'EXPIRED';
    case CANCELLED = 'CANCELLED';
    case REFUNDED = 'REFUNDED';
}
