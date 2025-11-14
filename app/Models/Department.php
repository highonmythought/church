<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Department extends Model
{

   protected $tables='departments';
      protected $fillable=[
        'name',
        'description'
      ];



    public function members()
{
    return $this->hasMany(Member::class);
}

}
