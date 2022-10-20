<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id == 2) {
            $data['departments'] = Department::all();
        } else {
            $data['departments'] = Department::where('company_id', Auth::user()->id)->get();
        }

        return view('admin.department.index', $data);
    }

    public function edit_department(Request $request)
    {
        $data = Department::where('id', $request->id)->first();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        //validate record
        if (Department::where('name', 'company_id', $request->name, $request->company_id)->first()) {
            return redirect()->back()->withErrors('Department already added');
        }
        $input['company_id'] = Auth::user()->id;

        $saveDepartment = Department::create($input);

        return redirect()->back()->with('message', 'Department added successfully');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $updateDepartment = Department::where('id', $id)->update(['name' => $request->name]);
        return redirect()->back()->with('message', 'Department updated successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $updateDepartment = Department::where('id', $id)->delete();
        return redirect()->back()->with('message', 'Department deleted successfully');
    }
    //
}
