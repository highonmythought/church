<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use HasFactory;

class Equipment extends Model
{
   protected $table ='equipments';
      protected $fillable=[
        'name',
        'description',
        'photo_path',
        'acquired_date',

      ];
}
