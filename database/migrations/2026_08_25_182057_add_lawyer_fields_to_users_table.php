<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('city')->nullable()->after('phone');
            $table->text('address')->nullable()->after('city');
            $table->string('role')->default('customer')->after('address');
            $table->string('specialization')->nullable()->after('role');
            $table->string('qualification')->nullable()->after('specialization');
            $table->string('experience_years')->nullable()->after('qualification');
            $table->string('consultation_fee')->nullable()->after('experience_years');
            $table->string('bar_council_number')->nullable()->after('consultation_fee');
            $table->decimal('rating', 2, 1)->default(0.0)->after('bar_council_number');
            $table->boolean('is_approved')->default(false)->after('rating');
            $table->string('available_days')->nullable()->after('is_approved');
            $table->time('available_time_start')->nullable()->after('available_days');
            $table->time('available_time_end')->nullable()->after('available_time_start');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'city', 'address', 'role',
                'specialization', 'qualification', 'experience_years',
                'consultation_fee', 'bar_council_number', 'rating',
                'is_approved', 'available_days', 'available_time_start', 'available_time_end'
            ]);
        });
    }
};