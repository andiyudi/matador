<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [
        'id',
    ];
    public function coreBusinesses()
    {
        return $this->belongsToMany(CoreBusiness::class, 'core_business_vendor');
    }

    public function classifications()
    {
        return $this->belongsToMany(Classification::class, 'classification_vendor');
    }

    public function vendorFiles()
    {
        return $this->hasMany(VendorFile::class);
    }

    public function procurement()
    {
        return $this->belongsToMany(Procurement::class, 'procurement_vendor');
    }
}
