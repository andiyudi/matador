<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getVendorCount(): JsonResponse
    {
        $registeredCount = Vendor::count();
        $activeCount = Vendor::where('status', 'Active')->count();
        $expiredCount = Vendor::where('status', 'Expired')->count();
        $blacklistCount = Vendor::where('is_blacklist', true)->count();
        $notBlacklistCount = Vendor::where('is_blacklist', false)->count();

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
