<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class IndividualMemberLedger extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'individual_member_ledgers';

    protected $fillable = [
       'member_id',
       'account_id',
       'description',
       'bank',
       'date',
       'teller_number',
        "debit",
        "credit",
       'is_loan',
        'is_repayment',
        'company_id'
    ];

    public function memberRecord()
    {
        $member = Membership::where('id', $this->member_id)->first();

        if ($member) {
            $memberRecord = $member->firstname.' '.$member->lastname.' '.$member->othername;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function bank()
    {
        $bank = BankAccount::where('id', $this->bank)->first();

        if ($bank) {
            $memberRecord = $bank->gl_name;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }

    public function account()
    {
        $account = Account::where('id', $this->account_id)->first();

        if ($account) {
            $memberRecord = $account->description;
        } else {
            $memberRecord = ' ';
        }

        return $memberRecord;
    }
   
}
