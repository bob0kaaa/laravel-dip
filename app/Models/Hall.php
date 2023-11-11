<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory;
    public $table = 'halls';

    /**
     * @var mixed
     */
    protected  $fillable = [
        'name',
        'col',
        'row',
        'count_vip',
        'count_normal',
        'seats_type',
        'open',
    ];
    /**
     * Return seances in this room
     *
     * @return HasMany
     */
    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }

    /**
     * Return seats in this room
     *
     * @return HasMany
     */
    public function seat(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
