<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    use HasFactory;
    public $table = 'seats';
    protected  $fillable = [
        'type', // R
        'free',
        'col_number',
        'row_number',
        'hall_id',
        'ticket_id',
        'seance_id',
    ];
    /**
     * Returns the hall where is the seat
     *
     * @return BelongsTo
     */

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function seance(): BelongsTo
    {
        return $this->belongsTo(Seance::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
