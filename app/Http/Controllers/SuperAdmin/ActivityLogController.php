<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $activities = ActivityLog::with(['user', 'company'])->latest()->paginate(20);
        return view('super-admin.activity-logs.index', compact('activities'));
    }
}
