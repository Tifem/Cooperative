<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Category;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class BankController extends Controller
{

    public function banks(Request $request)
    {
        
        $data['banks'] = BankAccount::where('category_id', 5)->get();
        return view('admin.bank', $data);
    }

    public function bankstore(Request $request)
    {

        try {

            $check = BankAccount::where('gl_name', $request->gl_name)->first();
            if ($check) {
                throw new \Exception('This Bank is already existing');
            }
            $bank = $request->all();
            $bank = BankAccount::create($request->all());
            $bank->gl_code = $bank->id;
            $bank->category_id = 5;
            $bank->save();

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

    public function getbankInfo(Request $request)
    {
        $bank = BankAccount::where('id', $request->id)->first();

        return response()->json($bank);
    }

    public function updatebank(Request $request)
    {
       if (BankAccount::where('gl_name', $request->gl_name)->first()) {
            return redirect()->back()->withErrors('This Record is already existing');
        }
        $bank = BankAccount::find($request->id);
        if ($bank) {
            $this->validate($request, [
                'gl_name' => 'required'
            ]);

            $input = $request->all();
            // dd($student);
            $bank->fill($input)->save();

            return redirect()->back()->with('success', 'Record updated successfully');
        }
    }

    public function deletebank(Request $request)
    {
        $id = $request->id;
        $bank = BankAccount::find($id);
        // dd($customer);
        $bank->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
