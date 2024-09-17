<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'type'];
    
    public static function getTotalBalance()
    {
        $deposits = self::where('type', 'deposit')->sum('amount');
        $withdrawals = self::where('type', 'withdrawal')->sum('amount');

        return $deposits - $withdrawals;
    }
}
