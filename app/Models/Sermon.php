<?php

namespace App\Models;
    use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Sermon extends Model
{
    protected $table ='sermons';
      protected $fillable = [
        'title',
        'pastor_id',
        'guest_preacher',
        'event_id',
        'summary',
        'bible_text',
        'date',
    ];






   public function pastor()
{
    return $this->belongsTo(Pastor::class, 'pastor_id');
}

protected $casts = [
        'date' => 'date', // ✅ tell Laravel this is a date
    ];

public function event()
{
    return $this->belongsTo(Event::class);
}

}
