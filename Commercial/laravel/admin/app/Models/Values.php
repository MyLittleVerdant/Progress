<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'picture',
        'sort',
        'relation_id',
        'relation_name'
    ];

    public function career()
    {
        return $this->belongsTo(Careers::class);
    }
}

