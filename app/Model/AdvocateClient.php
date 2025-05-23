<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdvocateClient extends Model
{
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->middle_name) . ' ' . ucfirst($this->last_name);
    }

    public function getNameAttribute()
    {
        return $name = ucfirst($this->attributes['first_name']) . ' ' . ucfirst($this->attributes['middle_name']) . ' ' . ucfirst($this->attributes['last_name']);

    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
