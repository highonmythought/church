<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class FinancialRecord extends Model
{
protected $table = 'financial_records';
protected $fillable = [
        'event_id',
        'type', // 'Tithe', 'Offering', or 'Donation'
        'description',
        'date',
        'amount',
    ];

    public function event()
{
    return $this->belongsTo(Event::class);
}

 protected $casts = [
        'date' => 'date', // ✅ tell Laravel this is a date
    ];


}
