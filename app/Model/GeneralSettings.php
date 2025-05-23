<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{

       public function countrys()
    {
        return $this->hasOne(Country::class,'id','country');
    }

    public function states()
    {
        return $this->hasOne(State::class,'id','state');
    }

    public function citys()
    {
        return $this->hasOne(City::class,'id','city');
    }
}
