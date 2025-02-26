<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Services\ExpenseTypeService;
use Illuminate\Support\Facades\Auth;

class ExpenseTypeController extends Controller
{
    protected $expenseTypeService;

    public function __construct(ExpenseTypeService $expenseTypeService)
    {
        $this->expenseTypeService = $expenseTypeService;
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $expenseTypes = $this->expenseTypeService->getAll($user_id);
        return view('expenseTypes.index',compact('expenseTypes'));
    }


}
