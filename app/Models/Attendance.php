<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Attendance extends Model
{
    protected $tables='attendances';
    protected $fillable=[
        'event_id',
        'date',
        'total_attendance',

    ];

     protected $casts = [
        'date' => 'date', // ✅ tell Laravel this is a date
    ];



    public function event()
{
    return $this->belongsTo(Event::class);
}

}
