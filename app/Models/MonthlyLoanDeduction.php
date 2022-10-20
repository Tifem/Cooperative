<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MonthlyLoanDeduction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_loan_deductions';
    protected $fillable = [
        'member_id',
        'glcode',
        'amount',
        'month'
    ];

    public function gl()
    {
        return $this->belongsTo('App\Models\Loan', 'glcode')->withDefault(['name' => '']);
    }

    public function ln()
    {
        return $this->belongsTo('App\Models\Loan', 'loan_name')->withDefault(['name' => '']);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Membership', 'member_id')->withDefault(['lastname' => '']);
    }

    public function code()
    {
        return $this->belongsTo('App\Models\Loan', 'glcode')->withDefault(['description' => '']);
    }
    public function MemberRecord()
    {
        $member = Membership::where('member_id', $this->member_id)->first();

        if ($member) {
            $memberRecord = $member->firstname.' '.$member->lastname.' '.$member->othername;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }
    public function glCode()
    {
        $member = Loan::where('id', $this->glcode)->first();

        if ($member) {
            $memberRecord = $member->description;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function totalAmount($month)
    {
        $record = MonthlyLoanDeduction::where('member_id', $this->member_id)->where('month', $month)->first();

        if ($record) {
            $allrecord = MonthlyLoanDeduction::where('member_id', $this->member_id)->where('month', $month)->get();
            $value = $allrecord->sum('amount');
        } else {
            $value = '0';
        }

        return $value;
    }
}
