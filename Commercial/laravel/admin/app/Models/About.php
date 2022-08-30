<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = "about";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'short_description',
        'description',
        'picture',
        'signature',
        'CEO_name',
        'first_quarter_num',
        'first_quarter_title',
        'second_quarter_num',
        'second_quarter_title',
        'third_quarter_num',
        'third_quarter_title',
        'fourth_quarter_num',
        'fourth_quarter_title',
        'sort',
        'whale',

    ];
}
