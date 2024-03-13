<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
            $table->date('join_date')->nullable();
            $table->decimal('monthly_fee', 15, 2)->nullable();
            $table->decimal('advance_amount', 15, 2)->nullable();
            $table->string('status')->default('active')->nullable();
            $table->string('address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('member_id');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('section_id')->constrained('sections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
