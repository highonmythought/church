<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Pledge extends Model
{
    protected $table = 'pledges';
    protected $fillable = [
        'name',
        'amount',
        'expected_payment_date',
        'notes',
        'is_paid',
        'amount_paid',
        'payment_date',
    ];

}
