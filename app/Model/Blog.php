<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public $fillable=['id','title','image','alt','date','description','status'];
}
