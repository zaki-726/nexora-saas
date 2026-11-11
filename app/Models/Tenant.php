<?php

namespace App\Models;

/**
 * Tenant is an alias of Company for multi-tenant SaaS architecture.
 */
class Tenant extends Company
{
    protected $table = 'companies';
}
