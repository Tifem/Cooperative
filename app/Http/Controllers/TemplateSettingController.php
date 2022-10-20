<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\TemplateSetting;
use Illuminate\Http\Request;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Auth;

class TemplateSettingController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 2) {
            $data['accounts'] =  Account::all();
        } else {
            $data['accounts'] =  Account::where('company_id', Auth::user()->id)->get();
        }

        if (Auth::user()->role_id == 2) {
            $data['settings'] =  TemplateSetting::all();
        } else {
            $data['settings'] =  TemplateSetting::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.template_setting', $data);
    }


    public function save(Request $request)
    {
        $input = $request->all();

        try {
            // check if account position has been set or position has an account
            $checkAccount = TemplateSetting::where('company_id', Auth::user()->id)->where('account_id', $request->account_id)->first();
            $checkPosition = TemplateSetting::where('company_id', Auth::user()->id)->where('position', $request->position)->first();
            if ($checkAccount || $checkPosition) {
                throw new \Exception('Duplicate Entry!');
            }
            $input['set_by'] = Auth::user()->id;
            $setting = TemplateSetting::where('company_id', Auth::user()->id)->create($input);

            return api_request_response(
                "ok",
                "Position Set Successfully!",
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
    public function gettemplate(Request $request)
    {
        $saving = TemplateSetting::where('company_id', Auth::user()->id)->where('id',  $request->id)->first();
        return response()->json($saving);
    }

    public function updatetemplate(Request $request)
    {

        try {
            $checkAccount = TemplateSetting::where('company_id', Auth::user()->id)->where('account_id', $request->account_id)->first();
            $checkPosition = TemplateSetting::where('company_id', Auth::user()->id)->where('position', $request->position)->first();
            if ($checkAccount || $checkPosition) {
                throw new \Exception('Duplicate Entry!');
            }
            $saving = TemplateSetting::where('company_id', Auth::user()->id)->find($request->id);
            if ($saving) {
                $this->validate($request, [
                    'account_id' => 'required',
                    'position' => 'required',
                ]);

                $input = $request->all();
                // dd($student);
                $saving->fill($input)->save();

                return redirect()->back()->with('message', 'Record updated successfully');
            }
        } catch (\Exception $exception) {

            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }

    public function deletetemplate(Request $request)
    {
        $id = $request->id;
        $saving = TemplateSetting::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $saving->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
