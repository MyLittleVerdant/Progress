<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavourDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'subtitle',
        'list',
        'picture',
        'relation_id',
        'relation_name',
        'sort',
    ];

    public function favour()
    {
        return $this->belongsTo(Favours::class);
    }

    public function medias()
    {
        return $this->hasMany(Medias::class, 'relation_id', 'id')
            ->where(['relation_name' => 'favour_detail']);
    }
}
