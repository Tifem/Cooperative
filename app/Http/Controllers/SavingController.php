<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Membership;
use App\Models\Account;
use App\Models\MonthlySaving;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SavingController extends Controller
{
    public function savingss(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['savings'] = Account::all();
        } else {
            $data['savings'] = Account::where('company_id', Auth::user()->id)->whereNull('is_loan')->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['glcodes'] = Membership::all();
        } else {
            $data['glcodes'] = Membership::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.saving', $data);
    }

    public function savingstore(Request $request)
    {
        try {

            // $check = Account::where('glcode', $request->glcode)->first();
            // if ($check) {
            //     throw new \Exception('This glcode is already existing');
            // }

            $check = Account::where('company_id', Auth::user()->id)->where('description', $request->description)->first();
            if ($check) {
                throw new \Exception('This Savings Name is already existing');
            }

            $input = $request->all();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer 1|xDVN0Toig1fMaK9SbQ4OxJMIt25X8ymlBbBXSA0z',
                'Accept' => 'application/json',
            ])->post('https://patna.ng/api/account/create-saving-account', $input);
            $jsondata = json_decode($response);

            if ($jsondata->status == 'ok') {
                $input['description'] = $request->description . ' Savings';
                $input['glcode'] = $jsondata->data->gl_code;
                $input['company_id'] = Auth::user()->id;
            } else {
                return api_request_response(
                    'error',
                    $jsondata->message,
                    bad_response_status_code()
                );
            }
            $saving = Account::where('company_id', Auth::user()->id)->create($input);
            $saving->save();
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

    public function update_saving(Request $request)
    {

        $saving = Account::where('company_id', Auth::user()->id)->find($request->id);
        if ($saving) {
            $this->validate($request, [
                'glcode' => 'required',
                'description' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $saving->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }


    public function getMemberSaving(Request $request)
    {
        // dd($request->id);
        $pp['data'] = $info = MonthlySaving::where('company_id', Auth::user()->id)->where('member_id', $request->id)->with(['dscr'])->get();
        return json_encode($pp);
        //dd($info);
    }

    public function getSavingById(Request $request)
    {
        $saving = Account::where('company_id', Auth::user()->id)->where('id',  $request->id)->first();
        return response()->json($saving);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletesaving(Request $request)
    {
        $id = $request->id;
        $saving = Account::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $saving->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
