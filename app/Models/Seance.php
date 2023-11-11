<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    public $table = 'seances';
    protected $fillable = [
        'seance_start',
        'film_id',
        'hall_id',
    ];

    /**
     * Returns the film - shows on this session
     *
     * @return BelongsTo
     */

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    /**
     * Return all tickets of this session
     *
     * @return HasMany
     */

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function seats(): HasMany
    {
        //return $this->hasMany('App\Seance', 'hall_id');
        return $this->hasMany(Seat::class);
    }
}
