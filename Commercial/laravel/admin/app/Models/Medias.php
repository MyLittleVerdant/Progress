<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medias extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file',
        'title',
        'subtitle',
        'type',
        'relation_id',
        'relation_name',
        'sort',

    ];

    public function favour()
    {
        return $this->belongsTo(Favours::class);
    }

    public function detail()
    {
        return $this->belongsTo(FavourDetails::class);
    }
}
