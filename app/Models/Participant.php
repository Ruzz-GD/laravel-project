<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'ticket_id',
        'registered_at',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
