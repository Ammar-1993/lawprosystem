<?php

namespace App;

use App\Notifications\AdminResetPassword;
use App\Traits\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasPermissionsTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'advocate_id',
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'mobile',
        'registration_no',
        'associated_name',
        'address',
        'city_id',
        'zipcode',
        'state_id',
        'country_id',
        'profile_img',
        'is_activated',
        'is_account_setup',
        'remember_token',
        'is_user_type',
        'invitation_status',
        'accepted_at',
        'current_package',
        'payment_id',
        'started_at',
        'expires_at',
        'last_login_at',
        'last_login_ip',
        'is_active',
        'is_expired',
        'otp',
        'is_otp_verify',
        'plateform',
        'created_at',
        'updated_at',
        'otp_date',
        'device_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */

    protected function scopeGetAdmin()
    {
        return $this->gard('admin')->user();
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }
    public function country()
    {
        return $this->belongsTo(Model\Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(Model\State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(Model\City::class, 'city_id');
    }
}
