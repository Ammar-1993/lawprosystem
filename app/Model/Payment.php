<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['advocate_id','package_id', 'payment_date','expires_at', 'transaction_id', 'status', 'payment_id', 'payment_summary', 'email', 'amount','coupon_code_id','coupon_code'];
}
