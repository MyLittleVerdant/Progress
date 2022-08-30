<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patronages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'preview_description',
        'detail_description',
        'link',
        'color',
        'preview_picture',
        'detail_picture',
        'sort',

    ];
}
