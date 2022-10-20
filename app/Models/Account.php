<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Account extends Model implements Auditable
{
    // use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'is_loan',
        'description',
        'glcode',
        'interest',
        'company_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'gl_code')->withDefault(['description'=>'Anonymous']);
    }
    
      public function Subcategory()
    {
        return $this->belongsTo('App\Models\Category', 'category_id')->withDefault(['description'=>'Anonymous']);
    }

    public function sav()
    {
        return $this->belongsTo('App\Models\Membership', 'glcode')->withDefault(['name' => '']);
    }
   
    public function deductionAmount($month,$id)
    {
        // dd($month, $id);
        $record = MonthlyDeduction::where('glcode', $this->id)->where('member_id', $id)->where('month', $month)->first();

        if ($record) {
            $value = $record->amount;
        } else {
            $value = '0';
        }

        return $value;
    }

}
