<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\MonthlyLoan;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MonthlyLoanController extends Controller
{
    public function monthly_loans(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['mloans'] = MonthlyLoan::all();
        } else {
            $data['mloans'] = MonthlyLoan::where('company_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['members'] = Membership::all();
        } else {
            $data['members'] = Membership::where('company_id', Auth::user()->id)->get();
        }

        return view('cooperative.monthlyloan', $data);
    }

    public function monthly_loanstore(Request $request)
    {
        try {

            $input = $request->all();
            $loan = MonthlyLoan::where('company_id', Auth::user()->id)->create($input);
            // $loan->save();
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

    public function update_monthly_loan(Request $request)
    {

        $loan = MonthlyLoan::where('company_id', Auth::user()->id)->find($request->id);
        if ($loan) {
            $this->validate($request, [
                'member_id' => 'required',
                'glcode' => 'required',
                'principal' => 'required',
                'interest_amount' => 'required',
                'monthly_deduction' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $loan->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function getmonthly_loanInfo(Request $request)
    {
        $loan = MonthlyLoan::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($loan);
    }

    public function deletemonthly_loan(Request $request)
    {
        $id = $request->id;
        $loan = MonthlyLoan::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $loan->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
