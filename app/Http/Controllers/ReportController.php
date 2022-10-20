<?php

namespace App\Http\Controllers;
use function App\Helpers\api_request_response;
use function App\Helpers\generate_random_password;
use function App\Helpers\generate_uuid;
use function App\Helpers\unauthorized_status_code;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use Illuminate\Support\Facades\Session;
use App\Models\Account;
use App\Models\Category;
use App\Models\Cashbook;
use Carbon\Carbon;
use App\Models\Receipt;
use App\Models\Journal;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chartOfAccount()
    {
        $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        $revenue = Receipt::all();
        $data['revenue']=$revenue->sum('amount');
        $data['lodge'] = Receipt::where('lodgement_status', 1)->sum('amount');
        $data['outstanding'] = Receipt::where('lodgement_status', 0)->sum('amount');
        $data['accounts'] = Account::all();
        return view('admin.report.charts_of_account', $data);
          
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalLedger()
    {
        $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        $income = Category::where('description', 'LIKE', "INCOME")->pluck('id')->toArray();  
        $incomeGroup =  Category::whereIn('category_parent', $income)->pluck('id')->toArray();
        $data['accounts']  = Account::whereIn('category_id', $incomeGroup)->get();
        // $data['accounts'] = Account::whereIn('gl_code', ["12","13","14","15","16","17"])->get();
        return view('admin.report.general-ledger', $data);
          
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cashbook()
    {
        $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        $revenue = Receipt::all();
        $data['revenue']=$revenue->sum('amount');
        $data['lodge'] = Receipt::where('lodgement_status', 1)->sum('amount');
        $data['outstanding'] = Receipt::where('lodgement_status', 0)->sum('amount');
        $income = Category::where('description', 'LIKE', "BANKS")->pluck('id')->toArray();  
        // $incomeGroup =  Category::whereIn('category_parent', $income)->pluck('id')->toArray();
        $data['accounts']  = Account::whereIn('category_id', $income)->get(); 
        // $data['accounts'] = Account::where('gl_code', 5)->get();
        return view('admin.report.cashbook', $data);
          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function trialBalance()
    {
        $data['transactions'] = Journal::all();
        $data['accounts'] = Account::all();
        return view('admin.report.trial_balance', $data);
        // $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        // $data['accounts'] = Account::all();
        // return view('admin.report.trial_balance', $data);
          
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function balanceSheet()
    {
        $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        $revenue = Receipt::all();
        $data['revenue']=$revenue->sum('amount');
        $data['lodge'] = Receipt::where('lodgement_status', 1)->sum('amount');
        $data['outstanding'] = Receipt::where('lodgement_status', 0)->sum('amount');
        $data['accounts'] = Account::all();
        return view('admin.report.balance_sheet', $data);
          
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function searchLedger(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;

        // $code = Account::where('id', $id)->first();
        // $value_code = $code->code;
        // // dd($value);

        if($input['start_date'] == null ||  $input['end_date'] == null ){
            $value = Journal::where('gl_code',  $id)->with(['user'])->get();
        }

        if($input['start_date'] == null &&  $input['end_date'] != null ){
            // $value = Receipt::where('gl_code',  $id)->get();
            $value = Journal::where('gl_code',  $id)->whereDate('created_at', '<', $input['end_date'])->with(['user'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] == null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            // dd($input['start_date']);
            $value = Journal::where('gl_code',  $id)->whereDate('created_at', '=', $input['start_date'])->with(['user'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] != null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
            $value = Journal::where('gl_code',  $id)->whereBetween('created_at', [
            $start_date, $end_date
            ])->with(['user'])->get();
        }

        // $start_date = Carbon::parse($request->start_date)
        // ->toDateTimeString();

        // $end_date = Carbon::parse($request->end_date)
        //         ->toDateTimeString();

        // $value = Journal::where('gl_code',  $value_code)->whereBetween('created_at', [
        // $start_date, $end_date
        // ])->get();
        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            $value
        );
          
        // return json_encode($value);
    }
    public function searchJournal(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;
    
        $start_date = Carbon::parse($request->start_date)
        ->toDateTimeString();

        $end_date = Carbon::parse($request->end_date)
                ->toDateTimeString();

        $value = Receipt::where('gl_code',  $id)->whereBetween('created_at', [
        $start_date, $end_date
        ])->get();
        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            $value
        );
          
        // return json_encode($value);
    }
    
     public function searchReceiptByCode(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;

        if($input['start_date'] == null ||  $input['end_date'] == null ){
            $value = Receipt::where('gl_code',  $id)->with(['user'])->get();
        }

        if($input['start_date'] == null &&  $input['end_date'] != null ){
            // $value = Receipt::where('gl_code',  $id)->get();
            $value = Receipt::where('gl_code',  $id)->whereDate('created_at', '<', $input['end_date'])->with(['user'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] == null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            // dd($input['start_date']);
            $value = Receipt::where('gl_code',  $id)->whereDate('created_at', '=', $input['start_date'])->with(['user'])->get();
        }
         
        if($input['start_date'] != null &&  $input['end_date'] != null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
            $value = Receipt::where('gl_code',  $id)->whereBetween('created_at', [
            $start_date, $end_date
            ])->with(['user'])->get();
        }
        
        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            $value
        );
          
        // return json_encode($value);
    }
    public function searchReceipt(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;

        if($input['start_date'] == null ||  $input['end_date'] == null ){
            $value = Receipt::where('bank_lodged',  $id)->where('lodgement_status', 1)->with(['user','lodger'])->get();
        }

        if($input['start_date'] == null &&  $input['end_date'] != null ){
            // $value = Receipt::where('bank_lodged',  $id)->get();
            $value = Receipt::where('bank_lodged',  $id)->whereDate('created_at', '<', $input['end_date'])->where('lodgement_status', 1)->with(['user','lodger'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] == null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            // dd($input['start_date']);
            $value = Receipt::where('bank_lodged',  $id)->whereDate('created_at', '=', $input['start_date'])->where('lodgement_status', 1)->with(['user','lodger'])->get();
        }
         
        if($input['start_date'] != null &&  $input['end_date'] != null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
            $value = Receipt::where('bank_lodged',  $id)->whereBetween('created_at', [
            $start_date, $end_date
            ])->with(['user','lodger'])->where('lodgement_status', 1)->get();
        }

        return api_request_response(
            "ok",
            "Search Complete!",
            success_status_code(),
            $value
        );
          
        // return json_encode($value);
    }

    public function searchReceipt2(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;

        if($input['start_date'] == null ||  $input['end_date'] == null ){
            $value = Receipt::where('bank_lodged',  $id)->get();
        }

        if($input['start_date'] == null &&  $input['end_date'] != null ){
            // $value = Receipt::where('bank_lodged',  $id)->get();
            $value = Receipt::where('bank_lodged',  $id)->whereDate('created_at', '<', $input['end_date'])->get();
        }


        if($input['start_date'] != null &&  $input['end_date'] == null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            // dd($input['start_date']);
            $value = Receipt::where('bank_lodged',  $id)->whereDate('created_at', '=', $input['start_date'])->get();
        }
        
       
        if($input['start_date'] != null &&  $input['end_date'] != null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
            $value = Receipt::where('bank_lodged',  $id)->whereBetween('created_at', [
            $start_date, $end_date
            ])->get();
        }
        // return api_request_response(
        //     "ok",
        //     "Search Complete!",
        //     success_status_code(),
        //     $value
        // );
          
        // return json_encode($value);
    }
    
     public function searchTrialBalanceByCode(Request $request)
    {
        // try{
        $input = $request->all();
        $id = $input['id'];
        $gl_code = $request->id;

        // $code = Account::where('id', $id)->first();
        // $value_code = $code->code;
        // // dd($value);

        if($input['start_date'] == null ||  $input['end_date'] == null ){
            $value = Journal::where('gl_code',  $id)->with(['user'])->get();
        }

        if($input['start_date'] == null &&  $input['end_date'] != null ){
            // $value = Receipt::where('gl_code',  $id)->get();
            $value = Journal::where('gl_code',  $id)->whereDate('created_at', '<', $input['end_date'])->with(['user'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] == null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            // dd($input['start_date']);
            $value = Journal::where('gl_code',  $id)->whereDate('created_at', '=', $input['start_date'])->with(['user'])->get();
        }

        if($input['start_date'] != null &&  $input['end_date'] != null ){
            $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
            $value = Journal::where('gl_code',  $id)->whereBetween('created_at', [
            $start_date, $end_date
            ])->with(['user'])->get();
        }

        // $start_date = Carbon::parse($request->start_date)
        // ->toDateTimeString();

        // $end_date = Carbon::parse($request->end_date)
        //         ->toDateTimeString();

        // $value = Journal::where('gl_code',  $value_code)->whereBetween('created_at', [
        // $start_date, $end_date
        // ])->get();
    //     return api_request_response(
    //         "ok",
    //         "Search Complete!",
    //         success_status_code(),
    //         $value
    //     );
          
    // } catch (\Exception $exception) {
    //         // DB::rollback();

    //         return api_request_response(
    //          'error',
    //          $exception->getMessage(),
    //          bad_response_status_code()
    //      );
    //     }
        // return json_encode($value);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
