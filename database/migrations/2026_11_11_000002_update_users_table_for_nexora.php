<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // super_admin, company_admin, user
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete()->after('role');
            $table->string('avatar')->nullable()->after('company_id');
            $table->string('phone')->nullable()->after('avatar');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['role', 'company_id', 'avatar', 'phone', 'status']);
        });
    }
};
