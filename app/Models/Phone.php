<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $table = "phone";
    protected $fillable = [
        'code',
        'phon',
        'user_id',
    ];
    protected $hidden = [
        'user_id',
    ];
    public $timestamps = false;

    ################## Begin relations #################
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    ################## End relations #################
}
