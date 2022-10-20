<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\Account;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class LoanController extends Controller
{
    public function loans(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['loans'] = Account::whereNotNull('is_loan')->get();
        } else {
            $data['loans'] = Account::where('company_id', Auth::user()->id)->whereNotNull('is_loan')->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['glcodes'] = Membership::all();
        } else {
            $data['glcodes'] = Membership::where('company_id', Auth::user()->id)->get();
        }

        return view('cooperative.loan', $data);
    }

    public function getLoanById(Request $request)
    {
        $loan = Account::where('company_id', Auth::user()->id)->where('id',  $request->id)->first();
        return response()->json($loan);
    }

    public function loanstore(Request $request)
    {
        try {
            // $check = Account ::where('glcode', $request->glcode)->first();
            // if ($check) {
            //     throw new \Exception('This glcode is already existing');
            // }
            $check = Account::where('company_id', Auth::user()->id)->where('description', $request->description)->first();
            if ($check) {
                throw new \Exception('This Loan Name is already existing');
            }

            $input = $request->all();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer 1|xDVN0Toig1fMaK9SbQ4OxJMIt25X8ymlBbBXSA0z',
                'Accept' => 'application/json',
                // 'payment_code' => $request->id,
            ])->post('https://patna.ng/api/account/create-loan-account', $input);
            // dd($response);
            $jsondata = json_decode($response);
            // dd($jsondata);
            if ($jsondata->status == 'ok') {
                $input['description'] = $request->description . ' Loan';
                $input['interest'] = $request->interest;
                $input['glcode'] = $jsondata->data->gl_code;
                $input['is_loan'] = 1;
                $input['company_id'] = Auth::user()->id;
                // $loan = Account::create($input);
            } else {
                return api_request_response(
                    'error',
                    $jsondata->message,
                    bad_response_status_code()
                );
                //     // $jsondata->getMessage();
            }
            $loan = Account::where('company_id', Auth::user()->id)->create($input);
            $loan->save();
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

    public function update_loan(Request $request)
    {

        // if (Account::where('description', $request->description)->first()) {
        //     return redirect()->back()->withErrors('This Record is already existing');
        // }
        $loan = Account::where('company_id', Auth::user()->id)->find($request->id);
        if ($loan) {
            $this->validate($request, [
                'description' => 'required',
                'interest' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $loan->fill($input)->save();

            return redirect()->back()->with('success', 'Record updated successfully');
        }
    }

    public function getloanInfo(Request $request)
    {
        $loan = Account::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($loan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_loan(Request $request)
    {
        $id = $request->id;
        $loan = Account::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $loan->delete();

        return redirect()->back()->with('success', 'Record deleted successfully');
    }
}
