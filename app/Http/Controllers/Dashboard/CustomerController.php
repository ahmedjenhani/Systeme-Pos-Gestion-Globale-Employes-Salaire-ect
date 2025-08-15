<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('customers.index', [
            'customers' => Customer::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    
    public function create()
    {
        return view('customers.create');
    }

    
    public function store(Request $request)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers,email',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'shopname' => 'required|string|max:50',
            'account_holder' => 'max:50',
            'account_number' => 'max:25',
            'bank_name' => 'max:25',
            'bank_branch' => 'max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Customer::create($validatedData);

        return Redirect::route('customers.index')->with('success', 'Le client a été créé avec succès!');
    }

    
    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer' => $customer,
        ]);
    }

    
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }

    
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers,email,'.$customer->id,
            'phone' => 'required|string|max:15|unique:customers,phone,'.$customer->id,
            'shopname' => 'required|string|max:50',
            'account_holder' => 'max:50',
            'account_number' => 'max:25',
            'bank_name' => 'max:25',
            'bank_branch' => 'max:50',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';

            
            if($customer->photo){
                Storage::delete($path . $customer->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Customer::where('id', $customer->id)->update($validatedData);

        return Redirect::route('customers.index')->with('success', 'Client mis à jour avec succès!');
    }

    
    public function destroy(Customer $customer)
    {
        
        if($customer->photo){
            Storage::delete('public/customers/' . $customer->photo);
        }

        Customer::destroy($customer->id);

        return Redirect::route('customers.index')->with('success', 'Client supprimé avec succès!');
    }
}
