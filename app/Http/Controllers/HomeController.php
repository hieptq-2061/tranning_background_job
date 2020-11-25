<?php

namespace App\Http\Controllers;

use App\Models\MonthlyEmail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $monthlyEmail = MonthlyEmail::latest()->first();
        if (!$monthlyEmail) {
            return "Không có cái job nào cả";
        }
        return view('welcome', compact('monthlyEmail'));
    }
}
