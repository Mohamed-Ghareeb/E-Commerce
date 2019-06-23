<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
      'depart_name_en',
      'depart_name_ar',
      'icon',
      'description',
      'keywords',
      'parent',
    ];

    public function parents()
    {
        return $this->hasMany('App\Model\Department', 'id', 'parent_id');
    }

}
