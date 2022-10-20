<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MonthlyDeduction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_deductions';
    protected $fillable = [
        'member_id',
        'glcode',
        'amount',
        'month',
        'company_id',
    ];

    public function gl()
    {
        return $this->belongsTo('App\Models\Account', 'glcode')->withDefault(['name' => '']);
    }

    public function ln()
    {
        return $this->belongsTo('App\Models\Account', 'loan_name')->withDefault(['name' => '']);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Membership', 'member_id')->withDefault(['lastname' => '']);
    }

    public function code()
    {
        return $this->belongsTo('App\Models\Account', 'glcode')->withDefault(['description' => '']);
    }
    public function MemberRecord()
    {
        // $member = Membership::where('member_id', $this->member_id)->first();
        $member = Membership::where('id', $this->member_id)->first();

        if ($member) {
            $memberRecord = $member->firstname.' '.$member->lastname.' '.$member->othername;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }
    public function glCode()
    {
        $member = Account::where('id', $this->glcode)->first();

        if ($member) {
            $memberRecord = $member->description;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function totalAmount($month)
    {
        $record = MonthlyDeduction::where('member_id', $this->member_id)->where('month', $month)->first();

        if ($record) {
            $allrecord = MonthlyDeduction::where('member_id', $this->member_id)->where('month', $month)->get();
            $value = $allrecord->sum('amount');
        } else {
            $value = '0';
        }

        return $value;
    }
    public function savingDeduction()
    {
        $savingAccounts = Account::whereNull('is_loan')->pluck('id')->toArray();
        // dd($this->month);
        $record = MonthlyDeduction::whereIn('glcode', $savingAccounts)->where('month', $this->month)->first();
        // dd($record);
        if ($record) {
            $allrecord = MonthlyDeduction::whereIn('glcode', $savingAccounts)->where('month', $this->month)->get();
            $value = $allrecord->sum('amount');
        } else {
            $value = '0';
        }

        return $value;
    }
    public function loanDeduction()
    {
        $laonAccounts = Account::whereNotNull('is_loan')->pluck('id')->toArray();
        $record = MonthlyDeduction::whereIn('glcode', $laonAccounts)->where('month', $this->month)->first();

        if ($record) {
            $allrecord = MonthlyDeduction::whereIn('glcode', $laonAccounts)->where('month', $this->month)->get();
            $value = $allrecord->sum('amount');
        } else {
            $value = '0';
        }

        return $value;
    }
    public function totalMonthlyDeduction()
    {
        $laonAccounts = Account::whereNotNull('is_loan')->pluck('id')->toArray();
        $record = MonthlyDeduction::where('month', $this->month)->first();

        if ($record) {
            $allrecord = MonthlyDeduction::where('month', $this->month)->get();
            $value = $allrecord->sum('amount');
        } else {
            $value = '0';
        }

        return $value;
    }
}
