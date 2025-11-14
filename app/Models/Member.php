<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Member extends Model
{
    use SoftDeletes;

    protected $table = 'members';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'gender',
        'dob' ,
        'department_id',
    ];

    protected $casts = [
        'dob' => 'date', // ✅ tell Laravel this is a date
    ];


    public function department()
{
    return $this->belongsTo(Department::class);
}

}

