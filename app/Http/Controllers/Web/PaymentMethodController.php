<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $user_id = Auth::user()->id;
        $paymentMethods = $this->paymentMethod->getAll($user_id);
        return view('paymentMethods.index',compact('paymentMethods'));
    }


}
