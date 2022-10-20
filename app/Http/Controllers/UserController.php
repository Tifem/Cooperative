<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view-user|view-user-details|edit-user|update-user', ['only' => ['index', 'store']]);
        // $this->middleware('permission:create-user', ['only' => ['store']]);
        // $this->middleware('permission:edit-user', ['only' => ['edit']]);
        // $this->middleware('permission:update-user', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['users'] = User::all();
        } else {
            $data['users'] = User::where('company_id', Auth::user()->id)->get();
        }
        
        if (Auth::user()->role_id == 2) {
            $data['roles'] = Role::orderBy('id', 'DESC')->get();
        }else{
            $data['roles'] = Role::where('company_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        

        return view('admin.users', $data);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required',
            'password' => 'required|same:confirm-password',
            'role_id' => 'required',
        ]);

        try {

            $input = $request->all();
            $input = User::where('company_id', Auth::user()->id)->create($request->all());
            $input['password'] = Hash::make($input['password']);
            $input->assignRole($request->input('roles'));
            $input->company_id = Auth::user()->id;
            $input->save();

            return api_request_response(
                'ok',
                'Record saved successfully!',
                success_status_code(),
            );
        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }

    public function show($id)
    {
        $user = User::where('company_id', Auth::user()->id)->find($id);

        return view('users.show', compact('user'));
    }

    public function update_user(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_no' => 'required',
            'roles' => 'required',
        ]);
        $input = $request->all();

        $user = User::where('company_id', Auth::user()->id)->find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function getUserInfor(Request $request)
    {
        $data['user'] = $user = User::where('company_id', Auth::user()->id)->where('id', $request->id)->first();
        $data['role'] = $user->roles->pluck('id')->all();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        User::where('company_id', Auth::user()->id)->find($id)->delete();

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }
}
