<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use App\Models\Attendence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AttendenceController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('attendence.index', [
            'attendences' => Attendence::sortable()
                ->select('date')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    
    public function create()
    {
        return view('attendence.create', [
            'employees' => Employee::all()->sortBy('name'),
        ]);
    }

    
    public function store(Request $request)
    {
        $countEmployee = count($request->employee_id);
        $rules = [
            'date' => 'required|date'
        ];

        
        for ($i = 1; $i <= $countEmployee; $i++) {
            $rules["status$i"] = 'required|string';
        }

        $validatedData = $request->validate($rules);

        
        Attendence::where('date', $validatedData['date'])->delete();

        for ($i=1; $i <= $countEmployee; $i++) {
            $status = 'status' . $i;
            $attend = new Attendence();

            $attend->date = $validatedData['date'];
            $attend->employee_id = $request->employee_id[$i];
            $attend->status = $request->$status ?? 'absent'; 

            $attend->save();
        }

        return Redirect::route('attendence.index')->with('success', 'Acompte de présence créé avec succès!');
    }

    
    public function show(Attendence $attendence)
    {
        
    }

    
    public function edit(Attendence $attendence)
    {
        return view('attendence.edit', [
            'attendences' => Attendence::with(['employee'])->where('date', $attendence->date)->get(),
            'date' => $attendence->date
        ]);
    }

    
    public function update(Request $request, Attendence $attendence)
    {
        
    }

    
    public function destroy(Attendence $attendence)
    {
        
    }
}
