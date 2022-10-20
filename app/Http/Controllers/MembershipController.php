<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\Membership;
use App\Models\User;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\MemberLoan;
use App\Models\MonthlySaving;
use App\Models\IndividualMemberLedger;
use App\Exports\MembershipExport;
use App\Imports\MembershipImport;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Redirect;

class MembershipController extends Controller
{
    public function memberships(Request $request)
    {
        $data['banks'] = Bank::all();
        if(Auth::user()->role_id == 2){
            $data['members'] = Membership::all();
        }else{
            $data['members'] = Membership::where('company_id', Auth::user()->id)->get();
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

        return view('cooperative.membership', $data);
    }

    public function membersAccount(){
        try {
            $savings = MonthlySaving::where('company_id', Auth::user()->id)->select('member_id')->distinct()->pluck('member_id')->toArray();
            $loans = MemberLoan::where('company_id', Auth::user()->id)->select('member_name')->distinct()->pluck('member_name')->toArray();
            $foo = collect($savings);
            $bar = collect($loans);
            $merged = $foo->merge($bar);
            // dd($merged);
            // $checkMemberLoan = MonthlyDeduction::select('member_id')->distinct()->pluck('member_id')->toArray();
            $data['members'] = Membership::where('company_id', Auth::user()->id)->whereIn('id', $merged)->get();
            // dd($data);
            return view('cooperative.member-accounts', $data);
        } catch (\Exception $exception) {
        
                return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }

 public function getMemberAccounts(Request $request){

        $savings = MonthlySaving::where('company_id', Auth::user()->id)->where('member_id', $request->id)->pluck('description')->ToArray();
        $loans = MemberLoan::where('company_id', Auth::user()->id)->where('member_name', $request->id)->pluck('loan_name')->ToArray();
        $foo = collect($savings);
        $bar = collect($loans);
        $merged = $foo->merge($bar);
        $pp['data'] = Account::where('company_id', Auth::user()->id)->whereIn('id',  $merged)->get();
        // dd($merged);
        return json_encode($pp);
    }

 public function memberAccountDeductions(Request $request){
        $value = IndividualMemberLedger::where('company_id', Auth::user()->id)->where('member_id', $request->id)->where('account_id', $request->account)->get();
        $debit = $value->sum('debit');
        $credit = $value->sum('credit');
        if($credit > 0){ 
            $amount = $credit ;
        }else{
            $amount = $debit ;
        }
        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            [$value , $amount]
        );

    }

    public function download_member_excel($member)
    {
        // dd($type);
        return \Excel::download(new MembershipExport(), 'memberships.'.$member);
    }

    public function upload_member_excel(Request $request)
    {
        try {
            \Excel::import(new MembershipImport(), request()->file('member_file')->store('temp'));

            return Redirect::back()->with(['success' => 'Member uploaded successfully!.']);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $errormess = '';
                foreach ($failure->errors() as $error) {
                    $errormess = $errormess.$error;
                }
                $errormessage[] = 'There was an error on Row '.' '.$failure->row().'.'.' '.$errormess;
            }

            return redirect()->back()->withErrors($errormessage);
        } catch (\Exception $exception) {
            $errorCode = $exception->errorInfo[1] ?? $exception;
            if (is_int($errorCode)) {
                return redirect()->back()->withErrors(['exception' => $exception->errorInfo[2]]);
            } else {
                dd($exception);
                return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
            }
        }
    }

    public function membershipstore(Request $request)
    {
        // $user=Auth::user()->id;
        // dd($user);
        try {
            // dd('yaaa');
            //check uniqueness of mail
            $check = Membership::where('company_id', Auth::user()->id)->where('firstname', $request->firstname)->where('lastname', $request->lastname)->where('othername', $request->othername)->first();
            if ($check) {
                throw new \Exception('This Record is already existing');
            }

            $check = Membership::where('company_id', Auth::user()->id)->where('phone_no', $request->phone_no)->first();
            if ($check) {
                throw new \Exception('This phone number is already existing');
            }

            $check = Membership::where('company_id', Auth::user()->id)->where('email', $request->email)->first();
            if ($check) {
                throw new \Exception('This email is already existing');
            }
            $check = Membership::where('company_id', Auth::user()->id)->where('account_number', $request->account_number)->first();
            if ($check) {
                throw new \Exception('This account number is already existing');
            }

           
            $member = $request->all();
            $member = Membership::where('company_id', Auth::user()->id)->create($request->all());
            $member->member_id = $member->id;
            $member->company_id = Auth::user()->id;
            $member->save();

            // $user = $request->all();
            $user = new User;
            $user->user_type = 'member';
            $user->name = $request->firstname .' ' . $request->lastname . ' '. $request->othername;
            $user->phone_no = $request->phone_no;
            $user->email = $request-> email;
            // $user->password = $request->phone_no;
            $user['password'] = (Hash::make($user['phone_no']));
            $user->company_id = Auth::user()->id;
            $user->member_id = $member->id;
            $user->save();

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

    public function update_membership(Request $request)
    {

        $member = Membership::where('company_id', Auth::user()->id)->find($request->id);
        if ($member) {
            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'othername' => 'required',
                'phone_no' => 'required',
                'home_address' => 'required',
                'email' => 'required',
                'sex' => 'required',
                'religion' => 'required',
                'account_number' => 'required',
                'account_name' => 'required',
                'bank_name' => 'required'
            ]);

            $input = $request->all();
            // dd($student);
            $member->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function getmembershipInfo(Request $request)
    {
        $member = Membership::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletemembership(Request $request)
    {
        $id = $request->id;
        $member = Membership::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $member->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
