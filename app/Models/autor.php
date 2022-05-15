<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class autor extends Model
{
    use HasFactory;
    protected $table = 'autors';
    public function user(){
        return $this->hasMany('App\post');
    }
  

}
