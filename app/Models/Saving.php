<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Saving extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'savings';
    protected $fillable = [
        'glcode',
        'description',
    ];
    public function sav()
    {
        return $this->belongsTo('App\Models\Membership', 'glcode')->withDefault(['name' => '']);
    }

   
}
