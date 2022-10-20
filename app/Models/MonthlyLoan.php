<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MonthlyLoan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_loans';
    protected $fillable = [
        'member_id',
        'glcode',
        'principal',
        'interest_amount',
        'monthly_deduction'
    ];
    
}
