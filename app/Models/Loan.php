<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Loan extends Model implements Auditable

{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'loans';
    protected $fillable = [
        'glcode',
        'description',
        'interest'
    ];

    public function sav()
    {
        return $this->belongsTo('App\Models\Membership', 'glcode')->withDefault(['name' => '']);
    }

    public function deductionAmount($month,$id)
    {
        // dd($month, $id);
        $record = MonthlyLoanDeduction::where('glcode', $this->id)->where('member_id', $id)->where('month', $month)->first();

        if ($record) {
            $value = $record->amount;
        } else {
            $value = '0';
        }

        return $value;
    }
}
