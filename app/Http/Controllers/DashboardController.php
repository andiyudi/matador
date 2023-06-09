<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getVendorCount(): JsonResponse
    {
        $registeredCount = Vendor::where('status', '0')->count();
        $activeCount = Vendor::where('status', '1')->count();
        $expiredCount = Vendor::where('status', '2')->count();
        $blacklistCount = Vendor::where('status', '3')->count();
        // $notBlacklistCount = Vendor::where('is_blacklist', '0')->count();

        $totalVendorCount = Vendor::count();

        return response()->json([
            'success' => true,
            'totalVendor' => $totalVendorCount,
            'registered' => $registeredCount,
            'active' => $activeCount,
            'expired' => $expiredCount,
            'blacklist' => $blacklistCount,
        ]);
    }

    public function getProcurementCount(): JsonResponse
    {
        $processProcurement = Procurement::where('status', '0')->count();
        $successProcurement = Procurement::where('status', '1')->count();
        $canceledProcurement = Procurement::where('status', '2')->count();
        $repeatedProcurement = Procurement::where('status', '3')->count();

        $totalProcurementCount = Procurement::count();

        return response()->json([
            'success' => true,
            'totalProcurement' => $totalProcurementCount,
            'processProcurement' => $processProcurement,
            'successProcurement' => $successProcurement,
            'canceledProcurement' => $canceledProcurement,
            'repeatedProcurement' => $repeatedProcurement,
        ]);
    }

    public function getDataTableVendor(): JsonResponse
    {
        $latestVendors = Vendor::orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $latestVendors,
        ]);
    }

    public function getDataTableProcurement(): JsonResponse
    {
        $latestProcurement = Procurement::orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $latestProcurement,
        ]);
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }
}
