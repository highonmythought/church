<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Pastor extends Model
{
    protected $table = 'pastors';
    protected $fillable = [
        'name',
        'rank',
        'phone',
        'email',
    ];




    public function sermons()
{
    return $this->hasMany(Sermon::class, 'preacher_id');
}

}
