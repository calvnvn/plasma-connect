<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function farmLocation()
    {
        return $this->hasOne(FarmLocation::class);
    }
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
