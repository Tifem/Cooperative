<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Redirect;
use App\Models\MemberLoan;
use App\Models\IndividualMemberLedger;
use App\Imports\TemplateDeduction;
use App\Models\MonthlySaving;
use App\Models\TemplateSetting;
use App\Models\MonthlyDeduction;
use App\Models\Loan;
use App\Models\Account;

class MonthlyDeductionController extends Controller
{

    // public function monthlydeductions1(Request $request)
    // {
    //     return view('cooperative.monthlydeduction');
    // }

    public function deductions(Request $request)
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

        return view('cooperative.report.monthly_deduction_details', $data);
    }

    public function filterDeductionDetails(Request $request)
    {
        // dd("here");
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
        $data['months'] = $months ?? [];
        if (Auth::user()->role_id == 2) {
            $data['deductions']  = $all = MonthlyDeduction::where('month', $request->id)->select('member_id', 'month')->distinct()->get();
        } else {
            $data['deductions']  = $all = MonthlyDeduction::where('company_id', Auth::user()->id)->where('month', $request->id)->select('member_id', 'month')->distinct()->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['loans'] = Account::all();
        } else {
            $data['loans'] = Account::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.report.monthly_deduction_details', $data);
    }
    public function deductions_summary()
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
        $data['months'] = $months ?? [];

        if (Auth::user()->role_id == 2) {
            $data['deductions']  = $all = MonthlyDeduction::select('month')->distinct()->get();
        } else {
            $data['deductions']  = $all = MonthlyDeduction::where('company_id', Auth::user()->id)->select('month')->distinct()->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['loans'] = Account::all();
        } else {
            $data['loans'] = Account::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.report.monthly_deduction_summary', $data);
    }

    public function filterDeductionSummary(Request $request)
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
        $data['months'] = $months ?? [];

        if (Auth::user()->role_id == 2) {
            $data['deductions']  = $all = MonthlyDeduction::where('month', $request->id)->select('month')->distinct()->get();
        } else {
            $data['deductions']  = $all = MonthlyDeduction::where('company_id', Auth::user()->id)->where('month', $request->id)->select('month')->distinct()->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['loans'] = Account::all();
        } else {
            $data['loans'] = Account::where('company_id', Auth::user()->id)->get();
        }

        return view('cooperative.report.monthly_deduction_summary', $data);
    }

    public function monthlydeductions(Request $request)
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
            if ($check == false) {
                $months[] = $thisMonth;
            }
        }
        // dd($months);
        $data['months'] = $months ?? [];

        if (Auth::user()->role_id == 2) {
            $data['loans'] = MonthlyDeduction::all();
        } else {
            $data['loans'] = MonthlyDeduction::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.monthlydeduction', $data);
    }

    public function monthlyDeductionTransaction(Request $request)
    {
        try {
            $check = MonthlyDeduction::where('company_id', Auth::user()->id)->where('month', $request->id)->first();
            if ($check) {
                throw new \Exception('Deduction has been made for this month! ');
                // throw new \Exception('You never pay the one u borrow finish! Unku Getaway');
            }
            if (Auth::user()->user_type == 'Admin') {
                // dd($request);
                $input = $request->all();
                $id = $input['id'];
                //loan deductions
                $memberLoans = MemberLoan::where('company_id', Auth::user()->id)->get();
                if (!empty($memberLoans)) {
                    foreach ($memberLoans as $member) {
                        //check amount left to be paid by this guy 
                        $balance = $member->balance;
                        if ($balance > 0) {
                            $save = new MonthlyDeduction;
                            $save->member_id = $member->member_name;
                            $save->glcode = $member->loan_name;
                            $save->amount = $member->monthly_deduction;
                            $save->company_id = Auth::user()->id;
                            $save->month = $id;
                            $save->save();
                            // insert into member ledger 
                            $loan = new IndividualMemberLedger;
                            $loan->member_id = $member->member_name;
                            $loan->account_id = $member->loan_name;
                            $loan->company_id = Auth::user()->id;
                            $loan->description = $id;
                            $loan->is_loan = 1;
                            $loan->debit = $member->monthly_deduction;
                            $loan->save();
                            // update balance for this guy 
                            $member->update(['balance' => $member->balance - $member->monthly_deduction]);
                        }
                    }
                }
                //saving deductions
                $memberSavings = MonthlySaving::where('company_id', Auth::user()->id)->get();
                if (!empty($memberSavings)) {
                    foreach ($memberSavings as $saving) {
                        $save = new MonthlyDeduction;
                        $save->member_id = $saving->member_id;
                        $save->glcode = $saving->description;
                        $save->amount = $saving->amount;
                        $save->company_id = Auth::user()->id;
                        $save->month = $id;
                        $save->save();
                        // insert into member ledger 
                        $loan = new IndividualMemberLedger;
                        $loan->member_id = $saving->member_id;
                        $loan->company_id = Auth::user()->id;
                        $loan->account_id = $saving->description;
                        $loan->description = $id;
                        $loan->credit = $saving->amount;
                        $loan->save();
                    }
                }
                $value = MonthlyDeduction::where('company_id', Auth::user()->id)->with(['member', 'code'])->get();
            }else{
                throw new \Exception('Only Admin is allowed to make deductions');
            }
            return api_request_response(
                "ok",
                "Search Complete!",
                success_status_code(),
                $value
            );
        } catch (\Exception $exception) {
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
        }
    }

    public function importDeductionTemplate(Request $request)
    {
        // dd($request->all());
        $input = $request->all();
        // dd($input);
        $account = $request->account_id;
        $month = $request->month;
        $setting = TemplateSetting::where('company_id', Auth::user()->id)->where('account_id', $request->account_id)->first();
        $position = $setting->position;
        if (empty($position)) {
            return redirect()->back()->withErrors(['exception' => 'Position not yet set for account']);
        }
        // dd($position);
        try {
            \Excel::import(new TemplateDeduction($position, $month, $account), request()->file('file')->store('temp'));

            return Redirect::back()->with(['success' => 'Transaction successful!.']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $errormess = '';
                foreach ($failure->errors() as $error) {
                    $errormess = $errormess . $error;
                }
                $errormessage[] = 'There was an error on Row ' . ' ' . $failure->row() . '.' . ' ' . $errormess;
            }

            return redirect()->back()->withErrors($errormessage);
        } catch (\Exception $exception) {
            $errorCode = $exception->errorInfo[1] ?? $exception;
            if (is_int($errorCode)) {
                return redirect()->back()->withErrors(['exception' => $exception->errorInfo[2]]);
            } else {
                // dd($exception);
                return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
            }
        }
    }

    public function excelMonthlydeductions(Request $request)
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
            if ($check == false) {
                $months[] = $thisMonth;
            }
        }
        // dd($months);
        $data['months'] = $months ?? [];

        if (Auth::user()->role_id == 2) {
            $data['accounts'] =  Account::all();
        } else {
            $data['accounts'] =  Account::where('company_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['loans'] = MonthlyDeduction::all();
        } else {
            $data['loans'] = MonthlyDeduction::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.excelmonthlydeduction', $data);
    }
}
