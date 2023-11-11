<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';

    protected  $fillable = [
        'title',
        'description',
        'duration',
        'image_path',
        'image_text',
        'origin',
    ];

    /**
     * Return seances with this film
     *
     * @return HasMany
     */

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }


}
