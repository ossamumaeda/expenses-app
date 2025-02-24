<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Services\PaymentMethodService;


class PaymentMethodController extends Controller
{
    protected $paymentMethod;

    public function __construct(PaymentMethodService $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function index()
    {
        $paymentMethods = $this->paymentMethod->getAll();
        return view('paymentMethods.index',compact('paymentMethods'));
    }


}
