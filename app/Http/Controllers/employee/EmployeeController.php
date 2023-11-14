<?php

namespace App\Http\Controllers\employee;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class EmployeeController extends Controller
{
    public function index()
    {
        $divisi = Divisi::all();
        $divisiId = auth()->user()->divisi_id;
        $divisiName = Divisi::find($divisiId);
        $status = DB::connection('rumahdrone_employee')->table('status')->get();

        return view('customer.main.add-user' , [
            'title' => 'User Add',
            'active' => 'add-user',
            'divisi' => $divisiName,
            'divisiList' => $divisi,
            'statusAdmin' => $status,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'is_admin' => 'required',
            'username' => ['required', Rule::unique('rumahdrone_employee.employee', 'username')],
            'password' => 'required|min:6|max:255',
            'alamat' => 'required',
            'telephone' => ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_employee.employee', 'telephone')],
            'email' => 'required|email:dns',
            'divisi_id' => 'required',
        ]);

        $validate['password'] = Hash::make($validate['password']);
        $validate['status_id'] = 1;

        $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
        $response = Http::post($appScriptUrl, [
            'first_name' => $validate['first_name'],
            'last_name' => $validate['last_name'],
            'email' => $validate['email'],
            'telephone' => $validate['telephone'],
        ]);
        // dd($validate);
 
        if($response->successful()){
            User::create($validate);
            return redirect('/customer/add-user')->with('success', 'Success Created New User.');
        } else{
            return redirect('/customer/add-user')->with('error', 'Failed to create a new user.');
        }
    }

}
