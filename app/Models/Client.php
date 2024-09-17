<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "address", "phone"];

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
}
