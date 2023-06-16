<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTestAddToLog(Request $request)
    {
        $logActivity = new LogActivity();
        $logActivity->addToLog('Deskripsi aktivitas', $request->url(), $request->method(), $request->ip(), $request->userAgent(), $request->user()->id);

        dd('log insert successfully.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logActivity(Request $request)
    {
        $logActivity = new LogActivity();
        $logs = LogActivity::all();
        return view('pages.logActivity', compact('logs'));
    }
}
