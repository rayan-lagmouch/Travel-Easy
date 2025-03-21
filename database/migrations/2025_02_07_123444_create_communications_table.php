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
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade'); // Maak nullable
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('title', 100);
            $table->string('message', 255);
            $table->dateTime('sent_at');
            $table->boolean('is_active')->default(true);
            $table->string('remarks', 255)->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
