<?php

namespace App\Services;

use App\Models\PaymentMethod;
/**
 * Will do the bridge between the models and the controller
 */
class PaymentMethodService {
    
    public function getAll(){
        $paymentMethod = PaymentMethod::all('id','name');
        return $paymentMethod;
    }

}