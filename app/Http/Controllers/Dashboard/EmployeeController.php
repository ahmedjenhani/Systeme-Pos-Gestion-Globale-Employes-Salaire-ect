<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('employees.index', [
            'employees' => Employee::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    
    public function create()
    {
        return view('employees.create');
    }

    
    public function store(Request $request)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:employees,email',
            'phone' => 'required|string|max:15|unique:employees,phone',
            'experience' => 'max:6|nullable',
            'salary' => 'required|numeric',
            'vacation' => 'max:50|nullable',
            'city' => 'required|max:50',
            'address' => 'required|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/employees/';

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Employee::create($validatedData);

        return Redirect::route('employees.index')->with('success', 'Employé créé avec succès!');
    }

    
    public function show(Employee $employee)
    {
        return view('employees.show', [
            'employee' => $employee,
        ]);
    }

    
    public function edit(Employee $employee)
    {
        return view('employees.edit', [
            'employee' => $employee,
        ]);
    }

    
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:employees,email,'.$employee->id,
            'phone' => 'required|string|max:20|unique:employees,phone,'.$employee->id,
            'experience' => 'string|max:6|nullable',
            'salary' => 'numeric',
            'vacation' => 'max:50|nullable',
            'city' => 'max:50',
            'address' => 'required|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/employees/';

            
            if($employee->photo){
                Storage::delete($path . $employee->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Employee::where('id', $employee->id)->update($validatedData);

        return Redirect::route('employees.index')->with('success', 'Employé mis à jour avec succès!');
    }

    
    public function destroy(Employee $employee)
    {
        
        if($employee->photo){
            Storage::delete('public/employees/' . $employee->photo);
        }

        Employee::destroy($employee->id);

        return Redirect::route('employees.index')->with('success', 'Employé supprimé avec succès!');
    }
}
