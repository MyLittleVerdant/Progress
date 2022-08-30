<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favours extends Model
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
        'link',
        'list',
        'key',
        'sort',
        'whale',
        'preview_picture',


    ];

    public function medias()
    {
        return $this->hasMany(Medias::class, "relation_id", "id")
            ->where(['relation_name' => 'favour']);
    }

    public function details()
    {
        return $this->hasMany(FavourDetails::class, "relation_id", "id")
            ->where(['relation_name' => 'favour']);
    }

}
