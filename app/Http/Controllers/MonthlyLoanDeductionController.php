<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\MonthlyLoanDeduction;
use App\Models\MonthlyDeduction;
use App\Models\MemberLoan;
use App\Models\Loan;
use Carbon\CarbonPeriod;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MonthlyLoanDeductionController extends Controller
{

    public function loanDeduction()
    {
        $start = '2022-01-01';
        $end = now();
        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $allMonths[] = $month->format('F Y');
        }
        $previousTransaction = MonthlyDeduction::where('company_id', Auth::user()->id)->select('month')->distinct()->pluck('month')->toArray();
        foreach ($allMonths as $thisMonth) {
            // dd($month);
            $check =  in_array($thisMonth, $previousTransaction);
            if ($check == true) {
                $months[] = $thisMonth;
            }
        }
        // dd($months);
        if (Auth::user()->role_id == 2) {
            $data['deductions']  = $all = MonthlyDeduction::select('member_id', 'month')->distinct()->get();
        } else {
            $data['deductions']  = $all = MonthlyDeduction::where('company_id', Auth::user()->id)->select('member_id', 'month')->distinct()->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['loans'] = Account::all();
        } else {
            $data['loans'] = Account::where('company_id', Auth::user()->id)->get();
        }
        $data['months'] = $months ?? [];     
        return view('cooperative.loan_pivot', $data);
    }
    public function monthlyLoanDeduction(Request $request)
    {

        $input = $request->all();
        $id = $input['id'];
        $memberLoans = MemberLoan::where('company_id', Auth::user()->id)->get();
        foreach ($memberLoans as $member) {
            $save = new MonthlyLoanDeduction;
            $save->member_id = $member->member_name;
            $save->glcode = $member->loan_name;
            $save->amount = $member->monthly_deduction;
            $save->month = $id;
            $save->save();
        }
        // dd($memberLoans);
        // dd($input);
        $value = MonthlyLoanDeduction::where('company_id', Auth::user()->id)->with(['member', 'code'])->get();
        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            $value
        );
        // return json_encode($value);
    }
    public function monthly_loan_deductions(Request $request)
    {
        $start = '2022-01-01';
        $end = now();
        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $allMonths[] = $month->format('F Y');
        }
        $previousTransaction = MonthlyLoanDeduction::where('company_id', Auth::user()->id)->select('month')->distinct()->pluck('month')->toArray();
        foreach ($allMonths as $thisMonth) {
            // dd($month);
            $check =  in_array($thisMonth, $previousTransaction);
            if ($check == false) {
                $months[] = $thisMonth;
            }
        }
        // dd($months);
        $data['months'] = $months;
        if (Auth::user()->role_id == 2) {
            $data['loans'] = MonthlyLoanDeduction::all();
        } else {
            $data['loans'] = MonthlyLoanDeduction::where('company_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['gls'] = Loan::all();
        } else {
            $data['gls'] = Loan::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.monthlyloandeduction', $data);
    }

    public function getmonthly_loan_deductionInfo(Request $request)
    {
        $loan = Loan::where('company_id', Auth::user()->id)->where('id',  $request->id)->first();
        return response()->json($loan);
    }
}
