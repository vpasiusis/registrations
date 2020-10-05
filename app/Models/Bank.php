<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'location',
        'workers_number',
        'created_at',
        'updated_at',
    ];
    use HasFactory;
}
