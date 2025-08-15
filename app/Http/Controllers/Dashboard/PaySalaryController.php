<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use App\Models\PaySalary;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PaySalaryController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The row parameter must be an integer between 1 and 100.');
        }

        if(request('search')){
            Employee::firstWhere('name', request('search'));
        }

        return view('pay-salary.index', [
            'advanceSalaries' => AdvanceSalary::with(['employee'])
                ->orderByDesc('date')
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    
    public function paySalary(String $id)
    {
        return view('pay-salary.create', [
            'advanceSalary' => AdvanceSalary::with(['employee'])
                ->where('id', $id)
                ->first(),
        ]);
    }

    public function payHistory()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The row parameter must be an integer between 1 and 100.');
        }

        if(request('search')){
            Employee::firstWhere('name', request('search'));
        }

        return view('pay-salary.history', [
            'paySalaries' => PaySalary::with(['employee'])
            ->orderByDesc('date')
            ->filter(request(['search']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query()),
        ]);
    }

    public function payHistoryDetail(String $id)
    {
        return view('pay-salary.history-details', [
            'paySalary' => PaySalary::with(['employee'])
            ->where('id', $id)
            ->first(),
        ]);
    }

    
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required|date_format:Y-m-d|max:10',
        ];

        $paySalary = AdvanceSalary::with(['employee'])
            ->where('id', $request->id)
            ->first();

        $validatedData = $request->validate($rules);

        $validatedData['employee_id'] = $paySalary->employee_id;
        $validatedData['paid_amount'] = $paySalary->employee->salary;
        $validatedData['advance_salary'] = $paySalary->advance_salary;
        $validatedData['due_salary'] = $paySalary->employee->salary - $paySalary->advance_salary;

        PaySalary::create($validatedData);

        return Redirect::route('pay-salary.payHistory')->with('success', 'Salaire de l\'employé payé avec succès!');
    }

    
    public function show(PaySalary $paySalary)
    {
        
    }

    
    public function edit(PaySalary $paySalary)
    {
        
    }

    
    public function update(Request $request, PaySalary $paySalary)
    {
        
    }

    
    public function destroy(PaySalary $paySalary)
    {
        PaySalary::destroy($paySalary->id);

        return Redirect::route('pay-salary.payHistory')->with('success', 'Historique de paiement de salaire supprimé avec succès!');
    }
}
