<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Debt;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "description", "price"];

    public function debts()
    {
        return $this->belongsToMany(Debt::class, 'debt_product')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
