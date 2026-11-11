<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\PlatformSetting;
use App\Models\Subscription;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. Super Admin User
        // -------------------------------------------------------------
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@nexora.test'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'status' => 'active',
                'phone' => '+1 (555) 019-2834',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        // -------------------------------------------------------------
        // 2. Platform Settings
        // -------------------------------------------------------------
        $settings = [
            ['group' => 'general', 'key' => 'app_name', 'value' => 'Nexora SaaS', 'type' => 'string'],
            ['group' => 'general', 'key' => 'support_email', 'value' => 'support@nexora.io', 'type' => 'string'],
            ['group' => 'billing', 'key' => 'currency', 'value' => 'USD', 'type' => 'string'],
            ['group' => 'billing', 'key' => 'currency_symbol', 'value' => '$', 'type' => 'string'],
            ['group' => 'billing', 'key' => 'tax_rate_percent', 'value' => '10', 'type' => 'integer'],
            ['group' => 'security', 'key' => 'enable_2fa', 'value' => 'true', 'type' => 'boolean'],
        ];
        foreach ($settings as $setting) {
            PlatformSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // -------------------------------------------------------------
        // 3. Subscription Plans (Starter, Pro, Enterprise)
        // -------------------------------------------------------------
        $starterPlan = Plan::updateOrCreate(
            ['slug' => 'starter-monthly'],
            [
                'name' => 'Starter Plan',
                'description' => 'Ideal for early stage startups and small teams.',
                'price' => 29.00,
                'billing_cycle' => 'monthly',
                'currency' => 'USD',
                'features' => ['Up to 5 Team Members', '10GB Storage', 'Standard Support', 'Basic Analytics'],
                'trial_days' => 14,
                'is_active' => true,
                'is_featured' => false,
            ]
        );

        $proPlan = Plan::updateOrCreate(
            ['slug' => 'pro-monthly'],
            [
                'name' => 'Pro Business Plan',
                'description' => 'For growing teams requiring advanced features & automation.',
                'price' => 79.00,
                'billing_cycle' => 'monthly',
                'currency' => 'USD',
                'features' => ['Up to 25 Team Members', '100GB Storage', 'Priority 24/7 Support', 'Advanced Analytics & Exports', 'Custom Domain'],
                'trial_days' => 14,
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        $enterprisePlan = Plan::updateOrCreate(
            ['slug' => 'enterprise-yearly'],
            [
                'name' => 'Enterprise Suite',
                'description' => 'Dedicated infrastructure, SSO and compliance security.',
                'price' => 199.00,
                'billing_cycle' => 'monthly',
                'currency' => 'USD',
                'features' => ['Unlimited Team Members', 'Unlimited Cloud Storage', 'Dedicated Account Manager', 'Custom Integrations & SLA', 'Audit Logs & SSO'],
                'trial_days' => 30,
                'is_active' => true,
                'is_featured' => false,
            ]
        );

        // -------------------------------------------------------------
        // 4. Exactly 10 Original Registered Companies (Latest 10 Tenants)
        // -------------------------------------------------------------
        $companiesData = [
            [
                'name' => 'Nexus Dynamics',
                'slug' => 'nexus-dynamics',
                'domain' => 'nexusdynamics.io',
                'email' => 'alex@nexusdynamics.io',
                'phone' => '+1 (800) 555-0110',
                'status' => 'active',
                'address' => '100 Innovation Way, Boston, MA',
                'owner_name' => 'Alex Rivera',
                'plan' => $enterprisePlan,
                'joined_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'BlueOrbit Technologies',
                'slug' => 'blue-orbit',
                'domain' => 'blueorbit.co',
                'email' => 'sophie@blueorbit.co',
                'phone' => '+1 (800) 555-0109',
                'status' => 'active',
                'address' => '450 Mission St, San Francisco, CA',
                'owner_name' => 'Sophie Martin',
                'plan' => $proPlan,
                'joined_at' => Carbon::now()->subDays(4),
            ],
            [
                'name' => 'DevPulse Software',
                'slug' => 'devpulse',
                'domain' => 'devpulse.dev',
                'email' => 'tariq@devpulse.dev',
                'phone' => '+1 (800) 555-0108',
                'status' => 'suspended',
                'suspension_reason' => 'Suspicious automated traffic spike flagged by security compliance audit.',
                'suspended_at' => Carbon::now()->subDays(1),
                'address' => '88 Tech Hub Ave, Seattle, WA',
                'owner_name' => 'Tariq Mansoor',
                'plan' => $starterPlan,
                'joined_at' => Carbon::now()->subDays(7),
            ],
            [
                'name' => 'Zenith Health AI',
                'slug' => 'zenith-health',
                'domain' => 'zenithhealth.ai',
                'email' => 'thorne@zenithhealth.ai',
                'phone' => '+1 (800) 555-0107',
                'status' => 'active',
                'address' => '300 BioMed Drive, Cambridge, MA',
                'owner_name' => 'Dr. Aris Thorne',
                'plan' => $enterprisePlan,
                'joined_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'SynthWave Studios',
                'slug' => 'synthwave-studios',
                'domain' => 'synthwave.media',
                'email' => 'chloe@synthwave.media',
                'phone' => '+1 (800) 555-0106',
                'status' => 'active',
                'address' => '90 Sunset Blvd, Los Angeles, CA',
                'owner_name' => 'Chloe Bennett',
                'plan' => $proPlan,
                'joined_at' => Carbon::now()->subDays(14),
            ],
            [
                'name' => 'Apex Logistics',
                'slug' => 'apex-logistics',
                'domain' => 'apexlogistics.com',
                'email' => 'david@apexlogistics.com',
                'phone' => '+1 (800) 555-0105',
                'status' => 'active',
                'address' => '120 Freight Way, Chicago, IL',
                'owner_name' => 'David Chen',
                'plan' => $enterprisePlan,
                'joined_at' => Carbon::now()->subDays(18),
            ],
            [
                'name' => 'HyperNova Digital',
                'slug' => 'hypernova',
                'domain' => 'hypernova.design',
                'email' => 'liam@hypernova.design',
                'phone' => '+1 (800) 555-0104',
                'status' => 'active',
                'address' => '12 Broadway, New York, NY',
                'owner_name' => "Liam O'Connor",
                'plan' => $starterPlan,
                'joined_at' => Carbon::now()->subDays(22),
            ],
            [
                'name' => 'CloudScale Labs',
                'slug' => 'cloudscale',
                'domain' => 'cloudscale.net',
                'email' => 'elena@cloudscale.net',
                'phone' => '+1 (800) 555-0103',
                'status' => 'active',
                'address' => '500 Tech Parkway, Austin, TX',
                'owner_name' => 'Elena Rostova',
                'plan' => $proPlan,
                'joined_at' => Carbon::now()->subDays(28),
            ],
            [
                'name' => 'TechFlow Systems',
                'slug' => 'techflow',
                'domain' => 'techflow.io',
                'email' => 'marcus@techflow.io',
                'phone' => '+1 (800) 555-0102',
                'status' => 'active',
                'address' => '100 Silicon Blvd, San Jose, CA',
                'owner_name' => 'Marcus Vance',
                'plan' => $enterprisePlan,
                'joined_at' => Carbon::now()->subDays(35),
            ],
            [
                'name' => 'Acme Corporation',
                'slug' => 'acme-corp',
                'domain' => 'acme.com',
                'email' => 'sarah.jenkins@acme.com',
                'phone' => '+1 (800) 555-0101',
                'status' => 'active',
                'address' => '742 Evergreen Terrace, Springfield, OR',
                'owner_name' => 'Sarah Jenkins',
                'plan' => $proPlan,
                'joined_at' => Carbon::now()->subDays(45),
            ],
        ];

        $createdCompanies = [];
        $createdSubscriptions = [];

        foreach ($companiesData as $c) {
            $plan = $c['plan'];
            $ownerName = $c['owner_name'];
            $joinedAt = $c['joined_at'];
            unset($c['plan'], $c['owner_name'], $c['joined_at']);

            $company = Company::updateOrCreate(['slug' => $c['slug']], array_merge($c, [
                'created_at' => $joinedAt,
                'updated_at' => $joinedAt,
            ]));

            // Company Owner
            $ownerUser = User::updateOrCreate(
                ['email' => $c['email']],
                [
                    'name' => $ownerName,
                    'password' => Hash::make('password'),
                    'role' => 'company_admin',
                    'company_id' => $company->id,
                    'status' => 'active',
                    'phone' => $company->phone,
                    'email_verified_at' => $joinedAt,
                    'created_at' => $joinedAt,
                    'updated_at' => $joinedAt,
                ]
            );

            // Pivot tenant_user
            DB::table('tenant_user')->updateOrInsert(
                ['user_id' => $ownerUser->id, 'company_id' => $company->id],
                ['role' => 'owner', 'created_at' => $joinedAt, 'updated_at' => $joinedAt]
            );

            // Additional Team Members per company
            for ($m = 1; $m <= 2; $m++) {
                $memberEmail = "member{$m}@{$company->slug}.test";
                $member = User::updateOrCreate(
                    ['email' => $memberEmail],
                    [
                        'name' => "{$company->name} Member {$m}",
                        'password' => Hash::make('password'),
                        'role' => 'user',
                        'company_id' => $company->id,
                        'status' => 'active',
                        'email_verified_at' => $joinedAt,
                        'created_at' => $joinedAt,
                        'updated_at' => $joinedAt,
                    ]
                );

                DB::table('tenant_user')->updateOrInsert(
                    ['user_id' => $member->id, 'company_id' => $company->id],
                    ['role' => 'member', 'created_at' => $joinedAt, 'updated_at' => $joinedAt]
                );
            }

            // Subscription
            $subStatus = ($company->status === 'active') ? 'active' : 'past_due';
            $subscription = Subscription::updateOrCreate(
                ['company_id' => $company->id],
                [
                    'plan_id' => $plan->id,
                    'status' => $subStatus,
                    'trial_ends_at' => $joinedAt->copy()->addDays(14),
                    'current_period_start' => Carbon::now()->startOfMonth(),
                    'current_period_end' => Carbon::now()->startOfMonth()->addMonth(),
                    'created_at' => $joinedAt,
                    'updated_at' => $joinedAt,
                ]
            );

            $createdCompanies[$company->slug] = $company;
            $createdSubscriptions[$company->slug] = $subscription;
        }

        // -------------------------------------------------------------
        // 5. Exactly 10 Original Recent Transactions (Stripe & PayPal)
        // -------------------------------------------------------------
        $transactionsData = [
            [
                'company_slug' => 'nexus-dynamics',
                'txn_id' => 'TXN-984210',
                'amount' => 199.00,
                'gateway' => 'stripe',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subHours(3),
            ],
            [
                'company_slug' => 'blue-orbit',
                'txn_id' => 'TXN-874192',
                'amount' => 79.00,
                'gateway' => 'stripe',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subHours(12),
            ],
            [
                'company_slug' => 'devpulse',
                'txn_id' => 'TXN-763910',
                'amount' => 29.00,
                'gateway' => 'paypal',
                'status' => 'pending',
                'paid_at' => null,
            ],
            [
                'company_slug' => 'zenith-health',
                'txn_id' => 'TXN-652814',
                'amount' => 199.00,
                'gateway' => 'stripe',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDays(1),
            ],
            [
                'company_slug' => 'synthwave-studios',
                'txn_id' => 'TXN-541708',
                'amount' => 79.00,
                'gateway' => 'paypal',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDays(2),
            ],
            [
                'company_slug' => 'apex-logistics',
                'txn_id' => 'TXN-430692',
                'amount' => 199.00,
                'gateway' => 'stripe',
                'status' => 'refunded',
                'paid_at' => Carbon::now()->subDays(3),
            ],
            [
                'company_slug' => 'hypernova',
                'txn_id' => 'TXN-329581',
                'amount' => 29.00,
                'gateway' => 'stripe',
                'status' => 'failed',
                'paid_at' => null,
            ],
            [
                'company_slug' => 'cloudscale',
                'txn_id' => 'TXN-218470',
                'amount' => 79.00,
                'gateway' => 'stripe',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDays(4),
            ],
            [
                'company_slug' => 'techflow',
                'txn_id' => 'TXN-107369',
                'amount' => 199.00,
                'gateway' => 'paypal',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDays(5),
            ],
            [
                'company_slug' => 'acme-corp',
                'txn_id' => 'TXN-096258',
                'amount' => 79.00,
                'gateway' => 'stripe',
                'status' => 'paid',
                'paid_at' => Carbon::now()->subDays(6),
            ],
        ];

        foreach ($transactionsData as $tIndex => $t) {
            $company = $createdCompanies[$t['company_slug']];
            $subscription = $createdSubscriptions[$t['company_slug']];

            $payment = Payment::updateOrCreate(
                ['transaction_id' => $t['txn_id']],
                [
                    'company_id' => $company->id,
                    'subscription_id' => $subscription->id,
                    'amount' => $t['amount'],
                    'currency' => 'USD',
                    'status' => $t['status'],
                    'payment_method' => $t['gateway'],
                    'paid_at' => $t['paid_at'],
                    'created_at' => $t['paid_at'] ?? Carbon::now()->subDays($tIndex),
                    'updated_at' => $t['paid_at'] ?? Carbon::now()->subDays($tIndex),
                ]
            );

            // Create Invoice
            Invoice::updateOrCreate(
                ['invoice_number' => 'INV-2026-' . str_pad($tIndex + 1, 4, '0', STR_PAD_LEFT)],
                [
                    'company_id' => $company->id,
                    'payment_id' => $payment->id,
                    'subtotal' => $t['amount'],
                    'tax' => round($t['amount'] * 0.10, 2),
                    'total' => round($t['amount'] * 1.10, 2),
                    'currency' => 'USD',
                    'status' => ($t['status'] === 'paid') ? 'paid' : 'unpaid',
                    'due_date' => Carbon::now()->addDays(15),
                    'paid_at' => $t['paid_at'],
                    'created_at' => $payment->created_at,
                    'updated_at' => $payment->updated_at,
                ]
            );
        }

        // -------------------------------------------------------------
        // 6. Support Tickets
        // -------------------------------------------------------------
        $ticketsData = [
            [
                'company_slug' => 'techflow',
                'ticket_no' => 'TCK-1001',
                'subject' => 'SSO SAML login timeout during peak hours',
                'message' => 'Okta SSO assertions are intermittent during login spike.',
                'priority' => 'urgent',
                'status' => 'open',
            ],
            [
                'company_slug' => 'nexus-dynamics',
                'ticket_no' => 'TCK-1002',
                'subject' => 'Custom Webhook signature verification mismatch',
                'message' => 'HMAC-SHA256 signature mismatch detected on webhook callback endpoint.',
                'priority' => 'high',
                'status' => 'in_progress',
            ],
            [
                'company_slug' => 'blue-orbit',
                'ticket_no' => 'TCK-1003',
                'subject' => 'Requesting VAT Invoice receipt for Q2 reconciliation',
                'message' => 'Please provide the tax breakdown invoice copy for accounting audit.',
                'priority' => 'low',
                'status' => 'resolved',
            ],
            [
                'company_slug' => 'zenith-health',
                'ticket_no' => 'TCK-1004',
                'subject' => 'HIPAA compliance audit export assistance',
                'message' => 'Need full platform audit log dump for annual regulatory compliance.',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'company_slug' => 'hypernova',
                'ticket_no' => 'TCK-1005',
                'subject' => 'Card billing retry notification after payment failure',
                'message' => 'Our corporate card was renewed; please trigger re-attempt on invoice #INV-2026-0007.',
                'priority' => 'medium',
                'status' => 'in_progress',
            ],
            [
                'company_slug' => 'acme-corp',
                'ticket_no' => 'TCK-1006',
                'subject' => 'Upgrade assistance to Enterprise plan seats',
                'message' => 'We are adding 40 engineering seats next week, need migration assistance.',
                'priority' => 'medium',
                'status' => 'open',
            ],
        ];

        foreach ($ticketsData as $td) {
            $comp = $createdCompanies[$td['company_slug']];
            SupportTicket::updateOrCreate(
                ['ticket_number' => $td['ticket_no']],
                [
                    'company_id' => $comp->id,
                    'user_id' => $comp->owner?->id ?? $superAdmin->id,
                    'subject' => $td['subject'],
                    'message' => $td['message'],
                    'priority' => $td['priority'],
                    'status' => $td['status'],
                    'last_reply_at' => Carbon::now()->subHours(rand(1, 18)),
                ]
            );
        }

        // -------------------------------------------------------------
        // 7. Platform Announcements
        // -------------------------------------------------------------
        Announcement::updateOrCreate(
            ['title' => 'Scheduled Maintenance: Sunday at 02:00 UTC'],
            [
                'content' => 'We will be upgrading database instances for faster global query performance. Expected downtime is 15 minutes.',
                'badge_type' => 'warning',
                'target' => 'all',
                'is_published' => true,
                'published_at' => Carbon::now()->subHours(10),
            ]
        );

        Announcement::updateOrCreate(
            ['title' => 'New Feature: Automated Tax Invoicing is live!'],
            [
                'content' => 'All tenants can now configure custom VAT/GST rates directly from the billing portal.',
                'badge_type' => 'success',
                'target' => 'all',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ]
        );

        // -------------------------------------------------------------
        // 8. Exactly 10 Original Activity Logs (Timeline)
        // -------------------------------------------------------------
        $activities = [
            ['action' => 'company.created', 'desc' => "New tenant 'Nexus Dynamics' registered with Enterprise Suite.", 'comp' => 'nexus-dynamics'],
            ['action' => 'payment.received', 'desc' => 'Settled $199.00 subscription renewal via Stripe for Nexus Dynamics.', 'comp' => 'nexus-dynamics'],
            ['action' => 'subscription.upgraded', 'desc' => 'BlueOrbit Technologies upgraded plan from Starter to Pro Business Plan.', 'comp' => 'blue-orbit'],
            ['action' => 'company.suspended', 'desc' => "Suspended tenant 'DevPulse Software'. Reason: Suspicious automated traffic spike.", 'comp' => 'devpulse'],
            ['action' => 'ticket.created', 'desc' => 'Priority ticket #TCK-1001 opened: SSO SAML login timeout during peak hours.', 'comp' => 'techflow'],
            ['action' => 'payment.refunded', 'desc' => 'Processed refund of $199.00 for Apex Logistics seat consolidation.', 'comp' => 'apex-logistics'],
            ['action' => 'announcement.published', 'desc' => "Platform announcement broadcasted: 'Automated Tax Invoicing is live!'.", 'comp' => null],
            ['action' => 'payment.failed', 'desc' => 'Recurring billing failed for HyperNova Digital ($29.00). Card expired.', 'comp' => 'hypernova'],
            ['action' => 'user.login', 'desc' => 'Super Administrator logged into Admin Console from verified IP 192.168.1.10.', 'comp' => null],
            ['action' => 'invoice.generated', 'desc' => 'Generated tax invoice INV-2026-0001 for Acme Corporation.', 'comp' => 'acme-corp'],
        ];

        foreach ($activities as $actIndex => $act) {
            $compId = $act['comp'] && isset($createdCompanies[$act['comp']]) ? $createdCompanies[$act['comp']]->id : null;
            ActivityLog::create([
                'user_id' => $superAdmin->id,
                'company_id' => $compId,
                'action' => $act['action'],
                'description' => $act['desc'],
                'ip_address' => '192.168.1.' . (10 + $actIndex),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/124.0.0.0 Safari/537.36',
                'created_at' => Carbon::now()->subMinutes(15 * ($actIndex + 1)),
                'updated_at' => Carbon::now()->subMinutes(15 * ($actIndex + 1)),
            ]);
        }
    }
}