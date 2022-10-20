<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\IndividualMemberLedger;
use App\Models\Membership;
use App\Models\BankAccount;
use App\Models\MemberLoan;
use App\Models\MonthlySaving;
use App\Models\MonthlyDeduction;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndividualMemberLedgerController extends Controller
{
    public function loanHome()
    {
        if (Auth::user()->role_id == 2) {
            $data['payments'] = IndividualMemberLedger::where('is_repayment', 1)->where('is_loan', 1)->get();
        } else {
            $data['payments'] = IndividualMemberLedger::where('company_id', Auth::user()->id)->where('is_repayment', 1)->where('is_loan', 1)->get();
        }
        $data['banks'] = BankAccount::where('category_id', 5)->get();
        $checkMemberLoan = MemberLoan::where('company_id', Auth::user()->id)->select('member_name')->distinct()->pluck('member_name')->toArray();
        if (Auth::user()->role_id == 2) {
            $data['members'] = Membership::whereIn('id', $checkMemberLoan)->get();
        } else {
            $data['members'] = Membership::where('company_id', Auth::user()->id)->whereIn('id', $checkMemberLoan)->get();
        }
        // dd($data);
        return view('cooperative.loan.loan_repayment_home', $data);
    }

    public function savingHome()
    {
        if (Auth::user()->role_id == 2) {
            $data['payments'] = IndividualMemberLedger::where('is_repayment', 1)->where('is_loan', 0)->get();
        } else {
            $data['payments'] = IndividualMemberLedger::where('company_id', Auth::user()->id)->where('is_repayment', 1)->where('is_loan', 0)->get();
        }
        $data['banks'] = BankAccount::where('category_id', 5)->get();
        $checkMemberLoan = MonthlySaving::where('company_id', Auth::user()->id)->select('member_id')->distinct()->pluck('member_id')->toArray();
        if (Auth::user()->role_id == 2) {
            $data['members'] = Membership::whereIn('id', $checkMemberLoan)->get();
        } else {
            $data['members'] = Membership::where('company_id', Auth::user()->id)->whereIn('id', $checkMemberLoan)->get();
        }
        // dd($data);
        return view('cooperative.saving.saving_home', $data);
    }

    public function savingPayment(Request $request)
    {
        $input = $request->except('_token');

        try {
            //  get loan details with incoming account_id 
            $memberLoan = MonthlySaving::where('company_id', Auth::user()->id)->where('id', $request->account_id)->first();
            $saving = $memberLoan->description;
            $input['credit'] = (preg_replace('/[^\d.]/', '', $request->amount));
            $input['description'] = "Bank Payment";
            $input['account_id'] = $saving;
            $input['company_id'] = Auth::user()->id;
            $date = $request->date;
            $value = Carbon::parse($date)->format('F Y');
            //   dd($value);
            $setting = IndividualMemberLedger::where('company_id', Auth::user()->id)->create($input);
            // save data into monthly deduction 
            $save = new MonthlyDeduction;
            $save->member_id = $request->member_id;
            $save->glcode = $saving;
            $save->amount = $input['credit'];
            $save->month = $value;
            $save->company_id =  $input['company_id'];
            $save->save();

            return api_request_response(
                "ok",
                "Transaction Submitted Successfully!",
                success_status_code(),
                $setting
            );
        } catch (\Exception $exception) {
            // DB::rollback();

            return api_request_response(
                "error",
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }
    public function loanRepayment(Request $request)
    {
        $input = $request->except('_token');

        try {
            //  get loan details with incoming account_id 
            $memberLoan = MemberLoan::where('company_id', Auth::user()->id)->where('id', $request->account_id)->first();
            $loan = $memberLoan->loan_name;
            $input['debit'] = (preg_replace('/[^\d.]/', '', $request->amount));
            $input['description'] = "Bank Repayment";
            $input['account_id'] = $loan;
            $input['company_id'] = Auth::user()->id;
            $date = $request->date;
            $value = Carbon::parse($date)->format('F Y');
            //   dd($value);
            $setting = IndividualMemberLedger::where('company_id', Auth::user()->id)->create($input);
            // save data into monthly deduction 
            $save = new MonthlyDeduction;
            $save->glcode = $loan;
            $save->amount = $input['debit'];
            $save->month = $value;
            $save->save();

            $memberLoan->update(['balance' => $memberLoan->balance - $input['debit']]);

            return api_request_response(
                "ok",
                "Transaction Submitted Successfully!",
                success_status_code(),
                $setting
            );
        } catch (\Exception $exception) {
            // DB::rollback();

            return api_request_response(
                "error",
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }
}
