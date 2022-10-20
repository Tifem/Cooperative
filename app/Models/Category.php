<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $fillable =[
        'description',
        'category_id',
        'has_child',
        'category_parent',
        'category_code',
        'code'
    ];

    public function items()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    // recursive relationship
    public function childServices()
    {
        return $this->hasMany(Category::class, 'category_id')->with('items');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function getParentsNames() {
        if($this->parent) {
            return $this->parent->getParentsNames(). " > " . $this->description;
        } else {
            return $this->description;
        }
    }
}
