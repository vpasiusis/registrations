<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    public $timestamps = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'content',
        'specialist_id',
        'bank_id',
        'expires_in',
    ];
    use HasFactory;
}
