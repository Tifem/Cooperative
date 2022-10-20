<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\MonthlySavingDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MonthlySavingDeductionController extends Controller
{
    public function saving_deductions(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['msdeductions'] = MonthlySavingDeduction::all();
        } else {
            $data['msdeductions'] = MonthlySavingDeduction::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.monthlysavingdeduction', $data);
    }

    public function saving_deductionstore(Request $request)
    {
        try {

            $input = $request->all();
            $saving = MonthlySavingDeduction::where('company_id', Auth::user()->id)->create($input);
            // $saving->save();
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

    public function updatesaving_deduction(Request $request)
    {

        $saving = MonthlySavingDeduction::where('company_id', Auth::user()->id)->find($request->id);
        if ($saving) {
            $this->validate($request, [
                'member_id' => 'required',
                'glcode' => 'required',
                'amount' => 'required',
                'transaction_date' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $saving->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function getsaving_deductionInfo(Request $request)
    {
        $saving = MonthlySavingDeduction::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($saving);
    }

    public function deletesaving_deduction(Request $request)
    {
        $id = $request->id;
        $saving = MonthlySavingDeduction::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $saving->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
