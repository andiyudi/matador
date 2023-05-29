<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcurementFile extends Model
{
    use HasFactory;
    protected $table = 'procurement_files';

    protected $fillable = [
        'procurement_id',
        'file_type',
        'file_name',
        'file_path',
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }
}
