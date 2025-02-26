<?php

namespace App\Services;

use App\Models\PaymentMethod;
/**
 * Will do the bridge between the models and the controller
 */
class PaymentMethodService {
    
    public function getAll($user_id){
        $paymentMethod = PaymentMethod::where('user_id', $user_id)->get(['id', 'name', 'color']);
        return $paymentMethod;
    }

    public function update($data,$user_id)
    {
        $paymentMethod = PaymentMethod::where('id', $data['id'])->where('user_id', $user_id)->first();
        $paymentMethod->update($data);

        return $paymentMethod;
    }

    public function store($data,$user_id){
        return PaymentMethod::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'color' => $data['color'],
            'user_id' => $user_id
        ]);
    }

    public function findById($id,$user_id){
        return PaymentMethod::where('id', $id)->where('user_id', $user_id)->first();
    }

}