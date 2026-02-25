<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        return view('budgets.index');
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit', compact('budget'));
    }

    public function print(Budget $budget)
    {
        $budget->load('items', 'company.services');

        return view('budgets.print', compact('budget'));
    }
}
