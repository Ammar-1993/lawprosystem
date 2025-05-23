<?php

namespace Witty\LaravelDbBackup\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dump
 * @package Witty\LaravelDbBackup\Models
 * @property string file
 * @property string file_name
 * @property string prefix
 * @property boolean encrypted
 * @property Carbon created_at
 */
class Dump extends Model
{
    /**
     * @var string
     */
    protected $dateFormat = 'U';
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'dumps';
    /**
     * @var array
     */
    protected $fillable = [
        'file', 'file_name', 'prefix', 'encrypted', 'created_at'
    ];

    public function setCreatedAtAttribute( $value ) {
  $this->attributes['created_at'] = date("Y-m-d H:i:s A");
}

}