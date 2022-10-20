<?php

namespace App\Http\Controllers;

use function App\Helpers\api_request_response;
use function App\Helpers\bad_response_status_code;
use function App\Helpers\success_status_code;
use App\Models\Account;
use App\Models\Cashbook;
use App\Models\Category;
use App\Models\CreateStockItem;
use App\Models\journal;
use App\Models\Receipt;
use App\StockCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class journalController extends Controller
{
    public function income_transac(Request $request)
    {
        $category = Category::where('description', 'LIKE', 'ASSETS')->pluck('id')->toArray();
        // dd($category);
        $check = Category::whereIn('category_parent', $category)->first();
        if($check){
            $group = Category::whereIn('category_parent', $category)->pluck('id')->toArray();
        }else{
            $group = $category;
        }
        $data['accounts'] = Account::whereIn('category_id', $group)->get();
        $income = Category::where('description', 'LIKE', 'INCOME')->pluck('id')->toArray();
        $incomeGroup = Category::whereIn('category_parent', $income)->pluck('id')->toArray();
        $data['incomes'] = Account::whereIn('category_id', $incomeGroup)->get();

        return view('admin.journal.create_income', $data);
    }

    public function journalIndex(){
        return view ('admin.journal.import');
    }

    public function total_incomes(Request $request)
    {
        $income = Category::where('description', 'LIKE', 'ASSETS')->pluck('id')->toArray();
        $incomeGroup = Category::whereIn('category_parent', $income)->pluck('id')->toArray();
        $data['accounts'] = Account::whereIn('category_id', $incomeGroup)->get();
        $data['transactions'] = Receipt::all();
        // dd($data);
        return view('admin.account.income', $data);
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $last = $request->category_id;
        if (is_array($last)) {
            $totalElements = count($request->category_id);
            $value = $last[$totalElements - 1];
        } else {
            $value = $request->category_id;
        }
        // dd($value);
        $test = CreateStockItem::where('category_id', $value)->get();
        $count = $test->count();
        $category = StockCategory::where('id', $value)->first();
        $codeValue = $category->category_code;
        // dd($input);
        try {
            $newAccount = new CreateStockItem();
            $newAccount->created_by = Auth::user()->id;
            $newAccount->name = $request->gl_name;
            $newAccount->category_id = $value;
            $newAccount->stock_code = $codeValue.''.'0'.''.$count + 1;
            $newAccount->classification = $request->classification;
            $newAccount->re_order_leel = $request->re_order_level;
            $newAccount->stock_id = rand();
            // dd($newAccount);

            return api_request_response(
                'ok',
                'Data Update successful!',
                success_status_code(),
                $newAccount
            );
        } catch (\Exception $exception) {
            // DB::rollback();

            return api_request_response(
             'error',
             $exception->getMessage(),
             bad_response_status_code()
         );
        }
    }

    public function deleteCategory(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $role = Category::find($id);
        // dd($role);
        $roles = Category::where('category_id', $request->id)->first();
        if (!empty($roles)) {
            $role->delete();

            return redirect()->back()->with('deleted', 'Delete Success!');
        } else {
            $update = Category::where('id', $request->id)->first();
            $update->update(['has_child' => 0]);
            $role->delete();

            return redirect()->back()->with('deleted', 'Delete Success!');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $role = StockCategory::find($id);
        // dd($role);
        $roles = StockCategory::where('category_id', $request->id)->first();
        if (!empty($roles)) {
            $role->delete();

            return redirect()->back()->with('deleted', 'Delete Success!');
        } else {
            $update = StockCategory::where('id', $request->id)->first();
            $update->update(['has_child' => 0]);
            $role->delete();

            return redirect()->back()->with('deleted', 'Delete Success!');
        }
    }

    public function index()
    {
        $category = Category::where('description', 'LIKE', 'EXPENSES')->orWhere('description', 'LIKE', 'INCOME')->pluck('id')->toArray();
        $group = Category::whereIn('category_parent', $category)->pluck('id')->toArray();
        $data['accounts'] = Account::whereIn('category_id', $group)->get();
        $income = Category::where('description', 'LIKE', 'ASSETS')->pluck('id')->toArray();
        $incomeGroup = Category::whereIn('category_parent', $income)->pluck('id')->toArray();
        $data['incomes'] = Account::whereIn('category_id', $incomeGroup)->get();
        $data['transactions'] = Receipt::where('lodgement_status', 0)->get();
        // dd($data);
        return view('admin.journal.index', $data);
    }

    public function income(Request $request)
    {
        if ($request->ajax()) {
            $income = Category::where('description', 'LIKE', 'ASSETS')->pluck('id')->toArray();
            $incomeGroup = Category::whereIn('category_parent', $income)->pluck('id')->toArray();
            $data['incomes'] = $payments = Account::whereIn('category_id', $incomeGroup)->where('created_at', '!=', null);
            // dd($income);
            return Datatables::of($payments)
            // dd($payments);
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function save(Request $request)
    {
        // dd("here");
        // $input = $request->all();
        $getCode = Account::where('id', $request->gl_code)->first();
        $code = $getCode->gl_code;
        $input = $request->except('_token');
        // $persie = intval(preg_replace('/[^\d.]/', '', $request->all_sum)) ;
        // dd($code);
        $input['particulars'] = $request->recepient_name;
        $input['teller_number'] = $request->teller_no;
        $item = $input['account_name'];
        $input['uuid'] = $order_id = rand();
        $input['voucher_number'] = $voucher = rand();
        $input['lodgement_status'] = 0;
        $input['amount'] = intval(preg_replace('/[^\d.]/', '', $request->all_sum));
        $input['created_by'] = Auth::user()->id;
        // $input['lodge_by'] = Auth::user()->id;
        Session::put('voucherrr', $input['voucher_number']);



        // begin txn here

        try {
            DB::beginTransaction();
            foreach ($item as $key => $item) {
                $journal = new journal();
                // $account->account_name = $input['account_name'][$key];
                $glcode = $input['account_name'][$key];
                $amount = intval(preg_replace('/[^\d.]/', '', $request->amount[$key]));
                $uuid = $input['uuid'];

                $this->doubleEntriesPoating($uuid, $glcode, 0 , $amount) ; // credit the  accounts
            }

           
            $gl_code = $request->gl_code;
            $debit = $input['amount'];
            $uuid = $input['uuid'];

            $this->doubleEntriesPoating($uuid, $gl_code, $debit,0) ; // debit the bank account


            $details = Receipt::create($input);
            $id = $details->uuid;

            // txn end here 
            DB::commit();


            return api_request_response(
                    'ok',
                    'Data Update successful!',
                    success_status_code(),
                    $details
                );
        } catch (\Exception $exception) {
            DB::rollBack();
            return api_request_response(
                'error',
                $exception->getMessage(),
                bad_response_status_code()
            );
            // return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }

    public function lodge(Request $request)
    {
        $data['items'] = Category::whereNull('category_id')->get();

        try {
            $category = Category::where('description', 'LIKE', 'BANKS')->pluck('id')->toArray();
            // dd($category);
            $check = Category::whereIn('category_parent', $category)->first();
            if($check){
                $group = Category::whereIn('category_parent', $category)->pluck('id')->toArray();
            }else{
                $group = $category;
            }
            $data['accounts'] = Account::whereIn('category_id', $group)->get();
            //  dd($income);
            // $data['accounts'] = Account::whereIn('gl_code', ["12","13","14","15","16","17"])->get();
            $input = $request->all();
            $uuid = $input['uuid'];
            $data['transactions'] = $stake = Receipt::whereIn('uuid', $uuid)->get();
            $data['sum'] = $stake->sum('amount');

            return view('admin.journal.lodge', $data);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }


    public function postDoubleEntries($uuid, $glcode, $debit,$credit, $detail)
    {
        $newJournal = new Journal();
        $newJournal->gl_code = $glcode;
        $newJournal->debit = $debit;
        $newJournal->credit = $credit;
        $newJournal->details = $detail;
        $newJournal->uuid = $uuid;
        $newJournal->save();
    }

    public function bankLodge(Request $request)
    {
        try {
            $input = $request->all();
            // dd($input);
            $uuid = $input['uuid'];
            $bankcode=$request->bank_lodge;
          
            // dd($uuid);
            foreach ($uuid as $key => $uuid) {
                // $checkUp[] = Receipt::where('uuid', $uuid)->first();
                $txns = Receipt::where('uuid', $uuid)->first();

               
                $glcode = $txns->gl_code;
                $amount =$txns->amount;

                ///txn beging

                $this->postDoubleEntries($uuid, $glcode, 0 , $amount) ; // credit the cash account

                $this->postDoubleEntries($uuid, $bankcode, $amount,0) ; // debit the bank account

             

                $cashbook = new Cashbook();
                $cashbook->transaction_date = Carbon::now();
                $cashbook->particular = $value->particulars;
                $cashbook->details = $value->description;
                $cashbook->bank = $value->amount;
                $cashbook->gl_code = $request->bank_lodge;
                $cashbook->save();

                $txns->update(['lodgement_status' => 1, 'bank_lodged' => $bankcode, 'date_lodged' => Carbon::now(), 'lodged_by' => Auth::user()->id]);
                // dd($newJournal);

                //end txn
            }

            return api_request_response(
                'ok',
                'Data Update successful!',
                success_status_code(),
                $value
            );
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['exception' => $exception->getMessage()]);
        }
    }
}
