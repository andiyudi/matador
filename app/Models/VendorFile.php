<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorFile extends Model
{
    use HasFactory;
    protected $table = 'vendor_files';

    // Kolom yang dapat diisi secara mass assignment
    protected $fillable = [
        'vendor_id',
        'file_type',
        'file_name',
        'file_path',
    ];

    // Relasi dengan model Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
