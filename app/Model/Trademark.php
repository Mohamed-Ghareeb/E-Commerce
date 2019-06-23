<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    protected $table = 'trademarks';
    protected $fillable = [
      'name_en',
      'name_ar',
      'logo',
    ];
}
