<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    protected $table = 'event_photos';
     protected $fillable = [
        'event_id',
        'photo_path',
    ];



    public function event()
{
    return $this->belongsTo(Event::class);
}

}
