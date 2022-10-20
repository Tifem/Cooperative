<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MemberLoan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'member_loans';
    protected $fillable = [
        'member_name',
        'loan_name',
        'principal_amount',
        'interest_amount',
        'total_repayment',
        'duration',
        'monthly_deduction',
        'loan_interest',
        'bank',
        'reciept_number',
        'balance',
        'status',
        'company_id'
    ];

    public function mbm()
    {
        return $this->belongsTo('App\Models\MemberLoan', 'member_name')->withDefault(['name' => '']);
    }
    public function ln()
    {
        return $this->belongsTo('App\Models\Account', 'loan_name')->withDefault(['name' => '']);
    }
    public function bnk()
    {
        return $this->belongsTo('App\Models\Account', 'bank')->withDefault(['name' => '']);
    }
    public function bankName()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bank')->withDefault(['name' => '']);
    }

    public function MemberRecord()
    {
        $member = Membership::where('id', $this->member_name)->first();

        if ($member) {
            $memberRecord = $member->firstname.' '.$member->lastname.' '.$member->othername;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function repayment()
    { 
        $monthlyDeduction = MonthlyDeduction::where('member_id', $this->member_name)->where('glcode', $this->loan_name)->get();
        $total = $monthlyDeduction->sum('amount');
        return $total;
    }

    
}
