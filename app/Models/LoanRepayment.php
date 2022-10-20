<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LoanRepayment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'member_loan_repayments';
    protected $fillable = [
        'transactiondate',
        'member_name',
        'loan_name',
        'amount_paid',
        'bank',
        'teller_number'
    ];

    public function bnk()
    {
        return $this->belongsTo('App\Models\Bank', 'bank')->withDefault(['name' => '']);
    }

}
