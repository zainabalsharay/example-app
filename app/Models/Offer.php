<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $table = "offers";
    protected $fillable = [
        'photo',
        'name_ar',
        'name_en',
        'price',
        'detalis_ar',
        'detalis_en',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public $timestamps = false;
}
