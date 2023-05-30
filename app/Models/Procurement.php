<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Procurement extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [
        'id',
    ];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'procurement_vendor')->withTimestamps();
    }

    public function files()
    {
        return $this->hasMany(ProcurementFile::class);
    }
}
