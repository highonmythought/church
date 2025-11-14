<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Event extends Model
{

     protected $tables='events';
  protected $fillable=[
    'event_type',
    'description',
    'date',
    'time',

  ];

   protected $casts = [
        'date' => 'date', // ✅ tell Laravel this is a date
    ];

   public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function sermons()
{
    return $this->hasMany(Sermon::class);
}

public function eventPhotos()
{
    return $this->hasMany(EventPhoto::class);

}
public function photos()
{
    return $this->hasMany(EventPhoto::class);
}

public function financialRecords()
{
    return $this->hasMany(FinancialRecord::class);
}

}
