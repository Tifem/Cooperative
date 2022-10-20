<?php

namespace App\Http\Controllers;

use App\Models\Cashbook;
use Illuminate\Http\Request;

class CashbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postToCashbook($transaction_date, $particular, $details, $bank, $gl_code, $chq_teller, $uuid, $payment_mode)
    {
        
        $cashbook = new Cashbook();
        $cashbook->transaction_date = $transaction_date;
        $cashbook->particular = $particular;
        $cashbook->details = $details;
        if(in_array($payment_mode, ["cash", "cheque"])){
            $cashbook->cash = $bank;
        }else{
            $cashbook->bank = $bank;
        }
        $cashbook->gl_code = $gl_code;
        $cashbook->chq_teller = $chq_teller;
        $cashbook->uuid = $uuid;
        $cashbook->save();
    }

}
