<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Search across Companies, Users, Subscriptions, and Transactions.
     * Supports both JSON API for topbar autocomplete & full Blade view.
     */
    public function search(Request $request): View|JsonResponse
    {
        $q = trim((string) $request->input('q', ''));

        if (empty($q)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'query' => '',
                    'total' => 0,
                    'companies' => [],
                    'users' => [],
                    'subscriptions' => [],
                    'payments' => [],
                ]);
            }

            return view('admin.search.index', [
                'query' => '',
                'companies' => collect(),
                'users' => collect(),
                'subscriptions' => collect(),
                'payments' => collect(),
                'totalResults' => 0,
            ]);
        }

        // 1. Database query: Companies (by name, slug, domain, email)
        $companies = Company::where('name', 'like', "%{$q}%")
            ->orWhere('slug', 'like', "%{$q}%")
            ->orWhere('domain', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->with(['activeSubscription.plan'])
            ->latest()
            ->take(8)
            ->get();

        // 2. Database query: Users (by name, email)
        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->with('company')
            ->latest()
            ->take(8)
            ->get();

        // 3. Database query: Subscriptions (by ID or related company/plan)
        $subscriptions = Subscription::where('id', $q)
            ->orWhereHas('company', function ($subQ) use ($q) {
                $subQ->where('name', 'like', "%{$q}%");
            })
            ->orWhereHas('plan', function ($subQ) use ($q) {
                $subQ->where('name', 'like', "%{$q}%");
            })
            ->with(['company', 'plan'])
            ->latest()
            ->take(8)
            ->get();

        // 4. Database query: Payments / Transactions (by transaction_id, id)
        $payments = Payment::where('transaction_id', 'like', "%{$q}%")
            ->orWhere('id', $q)
            ->orWhereHas('company', function ($subQ) use ($q) {
                $subQ->where('name', 'like', "%{$q}%");
            })
            ->with(['company', 'subscription.plan'])
            ->latest()
            ->take(8)
            ->get();

        $totalResults = $companies->count() + $users->count() + $subscriptions->count() + $payments->count();

        // If JSON requested (for instant topbar autocomplete modal)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'query' => $q,
                'total' => $totalResults,
                'companies' => $companies->map(fn ($c) => [
                    'id' => $c->id,
                    'title' => $c->name,
                    'subtitle' => $c->domain ?? ($c->slug . '.nexora.app'),
                    'badge' => ucfirst($c->status),
                    'url' => route('admin.companies.show', $c->id),
                ]),
                'users' => $users->map(fn ($u) => [
                    'id' => $u->id,
                    'title' => $u->name,
                    'subtitle' => $u->email,
                    'badge' => ucfirst(str_replace('_', ' ', $u->role)),
                    'url' => route('admin.users.index', ['search' => $u->email]),
                ]),
                'subscriptions' => $subscriptions->map(fn ($s) => [
                    'id' => $s->id,
                    'title' => '#' . $s->id . ' - ' . ($s->company->name ?? 'Company'),
                    'subtitle' => ($s->plan->name ?? 'Plan') . ' • ' . ucfirst($s->status),
                    'badge' => ucfirst($s->status),
                    'url' => route('admin.subscriptions.index'),
                ]),
                'payments' => $payments->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->transaction_id,
                    'subtitle' => ($p->company->name ?? 'Company') . ' • $' . number_format($p->amount, 2),
                    'badge' => ucfirst($p->status),
                    'url' => route('admin.payments.index'),
                ]),
            ]);
        }

        return view('admin.search.index', [
            'query' => $q,
            'companies' => $companies,
            'users' => $users,
            'subscriptions' => $subscriptions,
            'payments' => $payments,
            'totalResults' => $totalResults,
        ]);
    }
}
