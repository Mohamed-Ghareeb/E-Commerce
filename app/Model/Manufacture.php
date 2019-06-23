<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
  protected $table = 'manufactures';
  protected $fillable = [
    'man_name_en',
    'man_name_ar',
    'mobile',
    'email',
    'address',
    'facebook',
    'twitter',
    'website',
    'contact_name',
    'lat',
    'lng',
    'icon',
  ];
}
