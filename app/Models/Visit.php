<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visit';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'info',
        'type',
        'specialist_id',
        'bank_id',
        'userId',
        'state',
        'starting_time',
        'ending_time',
    ];
    use HasFactory;
}
