<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class subscriptionplan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'subscriptionplans';
    protected $fillable = [
        'plan_name',
        'plan_amount',
        'member_no',
        'savings_no',
        'loan_no'
    ];

}
