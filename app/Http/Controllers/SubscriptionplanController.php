<?php

namespace App\Http\Controllers;

use App\Models\subscriptionplan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Redirect;

class SubscriptionplanController extends Controller
{

    public function subscriptions(Request $request)
    {
        if (Auth::user()->role_id == 2) {
            $data['plans'] = subscriptionplan::all();
        } else {
            $data['plans'] = subscriptionplan::where('company_id', Auth::user()->id)->get();
        }
        return view('cooperative.subcriptionplan', $data);
    }

    public function subscriptionstore(Request $request)
    {
        try {
            $plan = $request->all();
            $plan = subscriptionplan::where('company_id', Auth::user()->id)->create($request->all());
            // $plan->plan_id = $plan->id;
            $plan->save();
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

    public function getsubscriptionInfo(Request $request)
    {
        $plan = subscriptionplan::where('company_id', Auth::user()->id)->where('id', $request->id)->first();

        return response()->json($plan);
    }


    public function updatesubscription(Request $request)
    {
        $plan = subscriptionplan::where('company_id', Auth::user()->id)->find($request->id);
        if ($plan) {
            $this->validate($request, [
                'plan_name' => 'required',
                'plan_amount' => 'required',
                'member_no' => 'required',
                'savings_no' => 'required',
                'loan_no' => 'required',
            ]);

            $input = $request->all();
            // dd($student);
            $plan->fill($input)->save();

            return redirect()->back()->with('message', 'Record updated successfully');
        }
    }

    public function deletesubscription(Request $request)
    {
        $id = $request->id;
        $plan = subscriptionplan::where('company_id', Auth::user()->id)->find($id);
        // dd($customer);
        $plan->delete();

        return redirect()->back()->with('message', 'Record deleted successfully');
    }
}
