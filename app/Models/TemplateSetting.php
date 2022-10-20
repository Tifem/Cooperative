<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TemplateSetting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'template_settings';
    protected $fillable = [
        'set_by',
        'account_id',
        'position',
        'company_id'
    ];

    public function account()
    {
        // dd($month, $id);
        $record = Account::where('id', $this->account_id)->first();

        if ($record) {
            $value = $record->description;
        } else {
            $value = "";
        }

        return $value;
    }

    
}
