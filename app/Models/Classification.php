<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'core_business_id'];

    public function coreBusiness()
    {
        return $this->belongsTo(CoreBusiness::class);
    }
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'classification_vendor');
    }
}
