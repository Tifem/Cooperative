<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\LoanRepayment;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Account;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;


class LoanRepaymentController extends Controller
{
    
    public function memberloanrepayments(Request $request)
    {
        $data['banks'] = Bank::all();

        if (Auth::user()->role_id == 2) {
            $data['repays'] = LoanRepayment::all();
        } else {
            $data['repays'] = LoanRepayment::where('company_id', Auth::user()->id)->get();
        }
        $category = Category::where('description', 'BANKS')->pluck('id')->toArray();
        // dd($category);
        $check = Category::whereIn('category_parent', $category)->first();
        if($check){
            $group = Category::whereIn('category_parent', $category)->pluck('id')->toArray();
        }else{
            $group = $category;
        }
        $data['accounts'] = BankAccount::whereIn('category_id', $group)->get();
        return view('cooperative.memberloanrepayment', $data);
    }

    
    public function memberloanrepaymentstore(Request $request)
    {
        try{
            $input = $request->all();
            $mloan = LoanRepayment::where('company_id', Auth::user()->id)->create($request->all());
            $mloan->save;

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

    public function getmemberloanrepaymentInfo(Request $request)
    {
        $mloan = LoanRepayment::where('company_id', Auth::user()->id)->where('id', $request->id)->first();
        return response()->json($mloan);
    }

    public function updatememberloanrepayment(Request $request)
    {
        $mloan = LoanRepayment::where('company_id', Auth::user()->id)->find($request->id);
        if($mloan) {
           $this->validate($request, [
            'transactiondate' => 'required',
            'member_name' => 'required',
            'loan_name' => 'required',
            'amount_paid' => 'required',
            'bank' => 'required',
            'teller_number' => 'required'
            ]);
        }
        $input = $request->all();
        $mloan->fill($input)->save();
        return redirect()->back()->with('success', 'Record updated succesfully');
    }

    public function deletememberloanrepayment(Request $request) {
        $id = $request->id;
        $mloan = LoanRepayment::where('company_id', Auth::user()->id)->find($id);
        $mloan->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}

