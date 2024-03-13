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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3);
            $table->string('status', 20)->default('Paid');
            $table->string('payment_method', 20)->default('Cash');
            $table->date('payment_date');
            $table->string('payment_for_month', 20);
            $table->string('member_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('contact_no', 255)->nullable();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
