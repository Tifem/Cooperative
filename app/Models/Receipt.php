<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Receipt extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'receipts';
    protected $fillable =[
        'uuid',
        'particulars',
        'description',
        'teller_number',
        'voucher_number',
        'transaction_date',
        'lodgement_status',
        'amount',
        'bank_lodged',
        'date_lodged',
        'currency',
        'payment_mode',
        'created_by',
        'gl_code',
        'lodge_by'
        ];

        public function user()
        {
            return $this->belongsTo('App\Models\User', 'created_by')->withDefault(['name'=>'Anonymous']);
        }
        
     public function lodger()
    {
        return $this->belongsTo('App\Models\User', 'lodge_by')->withDefault(['name' => '']);
    }
}
