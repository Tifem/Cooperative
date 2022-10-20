<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
// use App\Models\MonthlySaving;

use App\Models\Membership;
use App\Models\MonthlySaving;
use App\Models\Saving;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MonthlySavingController extends Controller
{
    public function monthly_savings(Request $request)
    {
        // $data['members'] = Membership::select('member_id'
        // )->distinct('member_id')->get();
        if (Auth::user()->role_id == 2) {
            $data['members'] = Membership::all();
        } else {
            $data['members'] = Membership::where('company_id', Auth::user()->id)->get();
        }
        if (Auth::user()->role_id == 2) {
            $data['gsavins'] = Account::all();
        } else {
            $data['gsavins'] = Account::where('company_id', Auth::user()->id)->whereNull('is_loan')->get();
        }
        if (Auth::user()->role_id == 2) {
            $data['msavings'] = MonthlySaving::all();
        } else {
            $data['msavings'] = MonthlySaving::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.membersaving', $data);
    }

    public function monthly_savingstore(Request $request)
    {
        try {

            $check = MonthlySaving::where('company_id', Auth::user()->id)->where('member_id', $request->member_id)->where('description', $request->description)->first();
            if ($check) {
                throw new \Exception('Member has ongoing package for this saving! Kindly reapply when repayment has been fully made!');
            }

            $saving = $request->all();
            $saving = MonthlySaving::where('company_id', Auth::user()->id)->create($request->all());
            $saving->company_id = Auth::user()->id;
            $saving->save();

            // $input = $request->all();
            // $saving = MonthlySaving::create($input);
            // $saving->company_id = Auth::user()->id;
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


    public function update_monthly_saving(Request $request)
    {

        $saving = MonthlySaving::where('company_id', Auth::user()->id)->find($request->id);
        if ($saving) {
            $this->validate($request, [
                'member_id' => 'required',
                'description' => 'required',
                'amount' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $saving->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function getmonthly_savingInfo(Request $request)
    {
        $saving = MonthlySaving::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($saving);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletemonthly_saving(Request $request)
    {
        $id = $request->id;
        $saving = MonthlySaving::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $saving->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
