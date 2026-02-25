<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('budget_number', 20);
            $table->string('client_name')->nullable();
            $table->string('client_cpf_cnpj', 18)->nullable();
            $table->string('client_address')->nullable();
            $table->enum('status', ['draft', 'sent', 'approved', 'rejected', 'expired'])->default('draft');
            $table->integer('valid_days')->default(7);
            $table->enum('discount_type', ['money', 'percent'])->default('money');
            $table->enum('discount_sign', ['discount', 'surcharge'])->default('discount');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
