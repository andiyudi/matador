<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getVendorCount(): JsonResponse
    {
        $registeredCount = Vendor::where('status', '0')->count();
        $activeCount = Vendor::where('status', '1')->count();
        $expiredCount = Vendor::where('status', '2')->count();
        $blacklistCount = Vendor::where('is_blacklist', '1')->count();
        $notBlacklistCount = Vendor::where('is_blacklist', '0')->count();

        return response()->json([
            'success' => true,
            'registered' => $registeredCount,
            'active' => $activeCount,
            'expired' => $expiredCount,
            'blacklist' => $blacklistCount,
            'notBlacklist' => $notBlacklistCount,
        ]);
    }
}
