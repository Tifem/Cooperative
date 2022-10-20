<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Cashbook extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'cashbooks';
    protected $fillable = [
        'pbank',
        'pcash',
        'bank',
        'cash',
        'details',
        'particular',
        'transaction_date',
        'gl_code',
        'chq_teller',
        'uuid'
    ];

    public function getAccountName()
    {
        $name = '';
        $account = Account::where('id',$this->gl_code)->first();
        if (!empty($account)) {
            $name = $account->gl_name;
        }

        return $name;

    }
}
