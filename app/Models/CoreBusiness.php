<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreBusiness extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
    ];

    public function classifications()
    {
        return $this->hasMany(Classification::class);
    }
}
