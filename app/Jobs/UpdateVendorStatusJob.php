<?php

namespace App\Jobs;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateVendorStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

        // Dapatkan vendor yang statusnya belum expired
        $vendors = Vendor::where('status', '!=', 'expired')->get();

        foreach ($vendors as $vendor) {
            // Cek apakah tanggal expired sudah melewati hari ini
            if ($vendor->expired_at < now()) {
                // Jika melewati, ubah status vendor menjadi 'expired'
                $vendor->status = '2';
                $vendor->save();
            }
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
