<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MonthlySavingDeduction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_saving_deductions';
    protected $fillable = [
        'member_id',
        'glcode',
        'amount',
        'transaction_date'
    ];
}
