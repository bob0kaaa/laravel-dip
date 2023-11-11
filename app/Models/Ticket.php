<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;
    public $table = 'tickets';
    protected  $fillable = [
        'qr_code',
        'count',
        'seat_id', //R
        'film_id',
        'seance_id',
    ];

    /**
     * Returns seances, that goes in this room
     *
     * @return BelongsTo
     */

    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class);
    }

    /**
     * Return characteristic seat of this ticket
     *
     * @return BelongsTo
     */

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }
}
