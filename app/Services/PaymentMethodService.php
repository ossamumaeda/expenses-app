<?php

namespace App\Services;

use App\Models\PaymentMethod;
/**
 * Will do the bridge between the models and the controller
 */
class PaymentMethodService {
    
    public function getAll(){
        $paymentMethod = PaymentMethod::all('id','name','color');
        return $paymentMethod;
    }

    public function update($data)
    {
        $paymentMethod = PaymentMethod::find($data['id']);
        $paymentMethod->update($data);

        return $paymentMethod;
    }

    public function store($data){
        PaymentMethod::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function findById($id){
        return PaymentMethod::find($id);
    }

}