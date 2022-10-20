<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Membership extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'memberships';
    protected $fillable = [
        'member_id',
        'firstname',
        'lastname',
        'othername',
        'phone_no',
        'home_address',
        'email',
        'sex',
        'religion',
        'account_number',
        'account_name',
        'bank_name',
        'company_id'
    ];

    public function bnk()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_name')->withDefault(['name'=> '']);
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
}
