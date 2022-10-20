<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Journal extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'journals';
    protected $fillable = [
        'uuid',
        'debit',
        'credit',
        'gl_code',
        'transaction_date'
    ];
    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'gl_code')->withDefault(['name'=>'Anonymous']);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by')->withDefault(['name' => 'Anonymous']);
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i A','modified' => 'datetime:Y-m-d H:i A'
    ];
}
