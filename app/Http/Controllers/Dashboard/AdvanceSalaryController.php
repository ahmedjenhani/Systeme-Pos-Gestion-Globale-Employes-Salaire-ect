<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdvanceSalaryController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        if(request('search')){
            Employee::firstWhere('name', request('search'));
        }

        return view('advance-salary.index', [
            'advance_salaries' => AdvanceSalary::with(['employee'])
                ->orderByDesc('date')
                ->filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    
    public function create()
    {
        return view('advance-salary.create', [
            'employees' => Employee::all()->sortBy('name'),
        ]);
    }

    
    public function store(Request $request)
    {
        $rules = [
            'employee_id' => 'required',
            'date' => 'required|date_format:Y-m-d|max:10',
            'advance_salary' => 'numeric|nullable'
        ];

        if ($request->date) {
            
            $getYm = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m');
        } else {
            $validatedData = $request->validate($rules);
        }


        $advanced = AdvanceSalary::where('employee_id', $request->employee_id)
            ->whereDate('date', 'LIKE',  $getYm . '%')
            ->get();

        if ($advanced->isEmpty()) {
            $validatedData = $request->validate($rules);
            AdvanceSalary::create($validatedData);

            return Redirect::route('advance-salary.create')->with('success', 'Acompte de salaire créé avec succès!');
        } else {
            return Redirect::route('advance-salary.create')->with('warning', 'Acompte de salaire déjà payé!');
        }
    }

    
    public function show(AdvanceSalary $advanceSalary)
    {
        
    }

    
    public function edit(AdvanceSalary $advanceSalary)
    {
        return view('advance-salary.edit', [
            'employees' => Employee::all()->sortBy('name'),
            'advance_salary' => $advanceSalary,
        ]);
    }

    
    public function update(Request $request, AdvanceSalary $advanceSalary)
    {
        $rules = [
            'employee_id' => 'required',
            'date' => 'required|date_format:Y-m-d|max:10|',
            'advance_salary' => 'required|numeric'
        ];

        
        $newYm = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y-m');
        $oldYm = Carbon::createFromFormat('Y-m-d', $advanceSalary->date)->format('Y-m');

        $advanced = AdvanceSalary::where('employee_id', $request->id)
            ->whereDate('date', 'LIKE',  $newYm . '%')
            ->first();

        if (!$advanced && $newYm == $oldYm) {
            $validatedData = $request->validate($rules);
            AdvanceSalary::where('id', $advanceSalary->id)->update($validatedData);

            return Redirect::route('advance-salary.edit', $advanceSalary->id)->with('success', 'Acompte de salaire mis à jour avec succès!');
        } else {
            return Redirect::route('advance-salary.edit', $advanceSalary->id)->with('warning', 'Acompte de salaire déjà payé!');
        }
    }

    
    public function destroy(AdvanceSalary $advanceSalary)
    {
        AdvanceSalary::destroy($advanceSalary->id);

        return Redirect::route('advance-salary.index')->with('success', 'Acompte de salaire supprimé avec succès!');
    }
}
