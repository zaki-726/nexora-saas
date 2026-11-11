<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    public function test_super_admin_can_access_dashboard_with_all_6_stat_cards(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Super Admin Dashboard');
        
        // Assert 6 Statistics Cards
        $response->assertSee('Total Companies');
        $response->assertSee('All registered tenants');
        
        $response->assertSee('Total Users');
        $response->assertSee('All platform accounts');
        
        $response->assertSee('Active Subscriptions');
        $response->assertSee('Currently active');
        
        $response->assertSee('Monthly Revenue');
        $response->assertSee('Gross volume (USD)');
        
        $response->assertSee('Pending Payments');
        $response->assertSee('Awaiting resolution');
        
        $response->assertSee('Open Tickets');
        $response->assertSee('Customer support queue');
    }

    public function test_revenue_analytics_endpoint(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        // 1. Default 6m
        $response = $this->actingAs($admin)->getJson('/admin/revenue-analytics?period=6m');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'period',
            'labels',
            'currentData',
            'previousData',
            'totalRevenue',
            'previousRevenue',
            'growth',
            'currency',
        ]);

        // 2. 7d period
        $res7d = $this->actingAs($admin)->getJson('/admin/revenue-analytics?period=7d');
        $res7d->assertStatus(200);
        $this->assertCount(7, $res7d->json('labels'));
    }

    public function test_subscription_analytics_endpoint(): void
    {
        $admin = User::where('role', 'super_admin')->first();

        $response = $this->actingAs($admin)->getJson('/admin/subscription-analytics');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'labels',
            'counts',
            'breakdown' => ['active', 'trial', 'expired', 'cancelled', 'past_due'],
            'total',
            'monthlyGrowth',
        ]);
    }

    public function test_super_admin_can_suspend_and_reactivate_company(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $company = Company::where('status', 'active')->first();

        // Suspend
        $resSuspend = $this->actingAs($admin)->post('/admin/companies/' . $company->id . '/suspend', [
            'reason' => 'Violation of fair compute usage policies.',
        ]);
        $resSuspend->assertSessionHas('success');

        $company->refresh();
        $this->assertEquals('suspended', $company->status);
        $this->assertEquals('Violation of fair compute usage policies.', $company->suspension_reason);
        $this->assertNotNull($company->suspended_at);

        // Reactivate
        $resActivate = $this->actingAs($admin)->post('/admin/companies/' . $company->id . '/activate');
        $resActivate->assertSessionHas('success');

        $company->refresh();
        $this->assertEquals('active', $company->status);
        $this->assertNull($company->suspension_reason);
        $this->assertNull($company->suspended_at);
    }

    public function test_search_queries_database_for_companies_users_subs_and_txns(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $company = Company::first();
        $user = User::where('role', 'company_admin')->first();
        $subscription = Subscription::first();
        $payment = Payment::first();

        // 1. Search company name (HTML)
        $response = $this->actingAs($admin)->get('/admin/search?q=' . urlencode($company->name));
        $response->assertStatus(200);
        $response->assertSee($company->name);

        // 2. Search user email (JSON autocomplete API)
        $jsonResponse = $this->actingAs($admin)->getJson('/admin/search?q=' . urlencode($user->email));
        $jsonResponse->assertStatus(200);
        $jsonResponse->assertJsonFragment([
            'title' => $user->name,
            'subtitle' => $user->email,
        ]);

        // 3. Search subscription ID
        $subResponse = $this->actingAs($admin)->getJson('/admin/search?q=' . $subscription->id);
        $subResponse->assertStatus(200);
        $this->assertNotEmpty($subResponse->json('subscriptions'));

        // 4. Search transaction reference
        $txnResponse = $this->actingAs($admin)->getJson('/admin/search?q=' . $payment->transaction_id);
        $txnResponse->assertStatus(200);
        $txnResponse->assertJsonFragment([
            'title' => $payment->transaction_id,
        ]);
    }

    public function test_super_admin_can_access_all_sidebar_modules(): void
    {
        $admin = User::where('role', 'super_admin')->first();
        $company = Company::first();
        $payment = Payment::first();
        $user = User::first();

        $routes = [
            '/admin/companies' => 'Companies Management',
            '/admin/companies/' . $company->id => 'Tenant Profile',
            '/admin/users' => 'Platform Users',
            '/admin/users/' . $user->id => 'User Profile',
            '/admin/plans' => 'Subscription Plans',
            '/admin/subscriptions' => 'Active Subscriptions',
            '/admin/payments' => 'Payments & Transactions',
            '/admin/payments/' . $payment->id => 'Payment Breakdown',
            '/admin/invoices' => 'Billing Invoices',
            '/admin/tickets' => 'Support Tickets',
            '/admin/announcements' => 'Platform Announcements',
            '/admin/activity-logs' => 'Activity Logs',
            '/admin/settings' => 'Platform Settings',
            '/admin/search' => 'Global Database Search',
        ];

        foreach ($routes as $url => $seeText) {
            $res = $this->actingAs($admin)->get($url);
            $res->assertStatus(200);
            $res->assertSee($seeText);
        }
    }
}
