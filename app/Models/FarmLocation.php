<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmLocation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'boundary_coordinates' => 'array',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
