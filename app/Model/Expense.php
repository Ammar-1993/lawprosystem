<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function expense_iteam()
    {
        return $this->hasMany('App\Model\ExpensesItem','invoice_id','id');
    }
}
