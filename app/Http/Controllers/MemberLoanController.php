<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\Loan;
use App\Http\Controllers\CashbookController;
use App\Http\Controllers\journalController;
use App\Models\MemberLoan;
use App\Models\Membership;
use App\Models\Category;
use App\Models\Account;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MemberLoanController extends Controller
{
    public function memberloans(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['loans'] = MemberLoan::all();
        } else {
            $data['loans'] = MemberLoan::where('company_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['members'] = Membership::all();
        } else {
            $data['members'] = Membership::where('company_id', Auth::user()->id)->get();
        }
        if (Auth::user()->role_id == 2) {
            $data['lnames'] = Account::all();
        } else {
            $data['lnames'] = Account::where('company_id', Auth::user()->id)->whereNotNull('is_loan')->get();
        }

        $category = Category::where('description', 'BANKS')->pluck('id')->toArray();
        // dd($category);
        $check = Category::whereIn('category_parent', $category)->first();
        if ($check) {
            $group = Category::whereIn('category_parent', $category)->pluck('id')->toArray();
        } else {
            $group = $category;
        }
        $data['accounts'] = BankAccount::whereIn('category_id', $group)->get();
        // dd($data);

        return view('cooperative.memberloan', $data);
    }

    public function memberloanstore(Request $request)
    {
        try {
            $check = MemberLoan::where('company_id', Auth::user()->id)->where('member_name', $request->member_name)->where('loan_name', $request->loan_name)->where('balance', '>', 0)->first();
            if ($check) {
                throw new \Exception('Member has ongoing package for this loan! Kindly reapply when repayment has been fully made! ');
                // throw new \Exception('You never pay the one u borrow finish! Unku Getaway');
            }

            $input = $request->all();
            $input['uuid'] = $uuid = rand();
            $input['principal_amount'] = (preg_replace('/[^\d.]/', '', $request->principal_amount));
            $input['interest_amount'] = (preg_replace('/[^\d.]/', '', $request->interest_amount));
            $input['total_repayment'] = (preg_replace('/[^\d.]/', '', $request->total_repayment));
            $input['monthly_deduction'] = (preg_replace('/[^\d.]/', '', $request->monthly_deduction));
            $input['loan_interest'] = (preg_replace('/[^\d.]/', '', $request->loan_interest));
            $input['balance'] = (preg_replace('/[^\d.]/', '', $request->total_repayment));
            $input['company_id'] = Auth::user()->id;
            $loan = MemberLoan::where('company_id', Auth::user()->id)->create($input);
            // $loan->save;
            $postJournal = new journalController;
            $glcode = $loan->loan_name;
            $amount = $loan->principal_amount;
            $detail = $loan->member_name;
            $particular = $loan->member_name;
            $bankcode = $loan->bank;
            $chq_teller = $loan->reciept_number;
            $transaction_date = now();
            $payment_mode = "Bank";

            $postJournal->postDoubleEntries($uuid, $bankcode, 0, $amount, $detail); // credit the bank account

            $postJournal->postDoubleEntries($uuid, $glcode,  $amount, 0, $detail); // debit the loan account

            $postCashbook = new CashbookController;
            $postCashbook->postToCashbook($transaction_date, $particular, $detail, $amount, $bankcode, $chq_teller, $uuid, $payment_mode); // save the bank lodge to cashbook

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

    // public function loanStatus()
    // {      
    //     $memberloans = MemberLoan::where('balance' > 0, 'status', 0 )->where('balance' == 0, 'status', 1 )->where('id', 'status', 2 )->get();
    //     $data['loans'] = $memberloans;
    //     return view ('cooperative.memberloan', $data)->with('i');     
    // }


    public function getmemberloanInfo(Request $request)
    {
        $loan = MemberLoan::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($loan);
    }

    public function getMemberloan(Request $request)
    {
        // dd($request->id);
        $pp['data'] = $info = MemberLoan::where('company_id', Auth::user()->id)->where('member_name', $request->id)->where('balance', '>', 0)->with(['ln'])->get();
        // dd($pp);
        return json_encode($pp);
        //dd($info);
    }

    public function updatememberloan(Request $request)
    {
        $loan = MemberLoan::where('company_id', Auth::user()->id)->find($request->id);
        //  dd($loan);
        if ($loan) {
            $this->validate($request, [
                'member_name' => 'required',
                'loan_name' => 'required',
                'principal_amount' => 'required',
                'interest_amount' => 'required',
                'total_repayment' => 'required',
                'duration' => 'required',
                'monthly_deduction' => 'required',
                'loan_interest' => 'required',
                'bank' => 'required',
                'reciept_number' => 'required'
            ]);

            $input = $request->all();
            // dd($student);
            $loan->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function deletememberloan(Request $request)
    {
        $id = $request->id;
        $loan = MemberLoan::where('company_id', Auth::user()->id)->find($id);
        $loan->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
