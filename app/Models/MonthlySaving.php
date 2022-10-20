<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MonthlySaving extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_savings';
    protected $fillable = [
        'member_id',
        'description',
        'glcode',
        'amount',
        'company_id'
    ];


    public function amt()
    {
        return $this->belongsTo('App\Models\Account', 'amount')->withDefault(['name' => '']);
    }

    public function dscr()
    {
        return $this->belongsTo('App\Models\Account', 'description')->withDefault(['name' => '']);
    }

    public function MemberRecord()
    {
        $member = Membership::where('id', $this->member_id)->first();

        if ($member) {
            $memberRecord = $member->firstname.' '.$member->lastname.' '.$member->othername;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function accountSavings()
    { 
        $monthlyDeduction = MonthlyDeduction::where('member_id', $this->member_id)->where('glcode', $this->description)->get();
        $total = $monthlyDeduction->sum('amount');
        return $total;
    }
    
}
