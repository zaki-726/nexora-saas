<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Company::with(['owner', 'users', 'activeSubscription.plan']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('domain', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $companies = $query->latest()->paginate(10)->withQueryString();

        return view('super-admin.companies.index', compact('companies'));
    }

    public function show(Company $company): View
    {
        $company->load([
            'owner',
            'users',
            'subscriptions.plan',
            'payments.subscription.plan',
            'invoices',
            'tickets',
            'activityLogs.user',
        ]);

        return view('super-admin.companies.show', compact('company'));
    }

    public function suspend(Request $request, Company $company): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        $company->suspend($validated['reason']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'action' => 'company.suspended',
            'description' => "Suspended tenant '{$company->name}'. Reason: {$validated['reason']}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "Tenant '{$company->name}' was suspended successfully. Workspace access is now disabled.");
    }

    public function activate(Request $request, Company $company): RedirectResponse
    {
        $company->activate();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'action' => 'company.activated',
            'description' => "Reactivated tenant '{$company->name}'. Full workspace access restored.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', "Tenant '{$company->name}' has been reactivated successfully.");
    }
}
