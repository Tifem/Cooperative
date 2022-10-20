<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BankAccount extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'bank_accounts';
    protected $fillable = [
        'gl_name',
        'category_id',
        'balance',
        'direction',
        'created_by',
        'gl_code',
        'lodged_by'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'gl_code')->withDefault(['description'=>'Anonymous']);
    }
    
      public function Subcategory()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->withDefault(['description'=>'Anonymous']);
    }
}
