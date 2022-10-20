<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IndividualMemberLedger;
use App\Models\User;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public static function getTotal($id)
    {
        $revenue = Receipt::all();
        $value = $revenue->sum('amount');
        return $value;
    }
    public function index(Request $request)
    {
        // dd($request->all());
        $id = $request->months;
        // $month = date('m', strtotime($id));
        
        $data['savings'] = IndividualMemberLedger::where('member_id', Auth::User()->member_id)->where('is_loan', 0)->where('description', $id)->get();

        $data['loans'] = IndividualMemberLedger::where('member_id', Auth::User()->member_id)->where('is_loan', 1)->where('description', $id)->get();

        $year =  Carbon::parse($id);
        // dd($year);
        for($i=1; $i < $year->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($year->year, $year->month, $i)->format('Y-m-d');
        }
        $data['dates'] = $dates;
        $data['now'] = now()->format('Y-m-d');
        $data['year'] = $year->format('Y-m-d');
        // // dd($data['now']);
        $start = '2022-01-01';
        $end = now();
        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $months[] = $month->format('F Y');
        }
        $data['months']=$months;
        return view('home', $data);
        
    }

    public function create(Request $request){
        $id = $request->months;
        $month = date('m', strtotime($id));
        
        $year =  Carbon::parse($id);
        // dd($year);
        for($i=1; $i < $year->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($year->year, $year->month, $i)->format('Y-m-d');
        }
        $data['dates'] = $dates;
        $data['now'] = now()->format('Y-m-d');
        $data['year'] = $year->format('Y-m-d');
        // // dd($data['now']);
        $start = '2022-01-01';
        $end = now();
        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $months[] = $month->format('F Y');
        }
        $data['months']=$months;

        $now = Carbon::now();
        $data['monthStart'] = $now->format('F Y');
        // dd($monthStart);
     
        
        return view('landing_page', $data);
    }
}
