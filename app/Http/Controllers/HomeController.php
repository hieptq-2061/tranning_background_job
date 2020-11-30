<?php

namespace App\Http\Controllers;

use App\Models\EmailJob;
use App\Models\MonthlyEmail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getStatisticData()
    {
        $monthlyEmail = MonthlyEmail::latest()->first();
        if (!$monthlyEmail) {
            return response()->json(['monthlyEmail' => null,]);
        }
        $totalJobSuccess = $monthlyEmail->email_jobs->where('status', 1)->count();
        $jobsFail = $monthlyEmail->email_jobs->where('status', 2);

        return response()->json([
            'monthlyEmail' => [
                'endedAt' => $monthlyEmail->ended_at,
                'totalJobs' => $monthlyEmail->total_jobs,
                'totalRunTime' => $monthlyEmail->getTotalRunningTimeAttribute(),
                'jobsDone' => $monthlyEmail->jobs_done,
            ],
            'totalJobSuccess' => $totalJobSuccess,
            'totalJobFail' => $jobsFail->count(),
            'failEmails' => $monthlyEmail->ended_at ? $jobsFail->pluck('email')->toArray() : [],
        ]);
    }
}
