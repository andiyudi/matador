<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function coreBusinesses()
    {
        return $this->belongsToMany(CoreBusiness::class, 'core_business_vendor');
    }

    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'classification_vendor');
    }
}
