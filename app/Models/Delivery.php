<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
