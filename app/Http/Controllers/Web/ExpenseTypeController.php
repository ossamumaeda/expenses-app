<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Services\ExpenseTypeService;


class ExpenseTypeController extends Controller
{
    protected $expenseTypeService;

    public function __construct(ExpenseTypeService $expenseTypeService)
    {
        $this->expenseTypeService = $expenseTypeService;
    }

    public function index()
    {
        $expenseTypes = $this->expenseTypeService->getAll();
        return view('expenseTypes.index',compact('expenseTypes'));
    }


}
