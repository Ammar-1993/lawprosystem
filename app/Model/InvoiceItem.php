<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
   
   public function servicesname()
   {
       return $this->hasOne(Service::class, 'id', 'service_id');
   }
}
