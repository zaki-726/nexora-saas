<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $activities = ActivityLog::with(['user', 'company'])->latest()->paginate(20);
        return view('admin.activities.index', compact('activities'));
    }
}
