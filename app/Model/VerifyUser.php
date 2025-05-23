<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    public function advocate()
    {
        return $this->belongsTo('App\Admin', 'advocate_id');
    }
}
