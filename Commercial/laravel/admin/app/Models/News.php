<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'preview_title',
        'detail_title',
        'date',
        'preview_description',
        'detail_description',
        'main_picture',
        'preview_picture',
    ];

    public $timestamps = false;
}
