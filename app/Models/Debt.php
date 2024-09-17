<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Product;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = ["client_id", "total"];

    public function customer()
        {
            return $this->belongsTo(Client::class);
        }

        public function products()
        {
            return $this->belongsToMany(Product::class, 'debt_product')
                        ->withPivot('quantity', 'price')
                        ->withTimestamps();
        }
}
