<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('cnpj', '12.345.678/0001-90')->first();
        $client1 = Client::where('email', 'joao@email.com')->first();
        $client2 = Client::where('email', 'maria@email.com')->first();

        // Budget 1 - Approved
        $budget1 = Budget::withoutGlobalScopes()->create([
            'company_id'      => $company1->id,
            'client_id'       => $client1->id,
            'budget_number'   => 'ORÇ-' . date('Y') . '-001',
            'client_name'     => $client1->name,
            'client_cpf_cnpj' => $client1->cpf_cnpj,
            'client_address'  => $client1->address,
            'status'          => 'approved',
            'valid_days'      => 15,
            'discount_type'   => 'percent',
            'discount_sign'   => 'discount',
            'discount_value'  => 5.00,
            'notes'           => 'Pagamento em 2x. Material incluído. Prazo de execução: 5 dias úteis.',
        ]);

        BudgetItem::create(['budget_id' => $budget1->id, 'description' => 'Gesso liso em paredes – sala', 'quantity' => 45.000, 'unit_price' => 25.00, 'sort_order' => 0]);
        BudgetItem::create(['budget_id' => $budget1->id, 'description' => 'Gesso liso em teto – sala', 'quantity' => 20.000, 'unit_price' => 30.00, 'sort_order' => 1]);
        BudgetItem::create(['budget_id' => $budget1->id, 'description' => 'Sanca de gesso – sala', 'quantity' => 12.000, 'unit_price' => 45.00, 'sort_order' => 2]);
        BudgetItem::create(['budget_id' => $budget1->id, 'description' => 'Mão de obra', 'quantity' => 1.000, 'unit_price' => 350.00, 'sort_order' => 3]);

        // Budget 2 - Draft
        $budget2 = Budget::withoutGlobalScopes()->create([
            'company_id'      => $company1->id,
            'client_id'       => $client2->id,
            'budget_number'   => 'ORÇ-' . date('Y') . '-002',
            'client_name'     => $client2->name,
            'client_cpf_cnpj' => $client2->cpf_cnpj,
            'client_address'  => $client2->address,
            'status'          => 'draft',
            'valid_days'      => 7,
            'discount_type'   => 'money',
            'discount_sign'   => 'discount',
            'discount_value'  => 100.00,
            'notes'           => 'Verificar disponibilidade de material.',
        ]);

        BudgetItem::create(['budget_id' => $budget2->id, 'description' => 'Drywall – quarto', 'quantity' => 30.000, 'unit_price' => 60.00, 'sort_order' => 0]);
        BudgetItem::create(['budget_id' => $budget2->id, 'description' => 'Textura grafiato – fachada', 'quantity' => 15.000, 'unit_price' => 35.00, 'sort_order' => 1]);

        // Company 2 budget
        $company2 = Company::where('cnpj', '98.765.432/0001-10')->first();
        $client3 = Client::where('email', 'pedro@email.com')->first();

        $budget3 = Budget::withoutGlobalScopes()->create([
            'company_id'      => $company2->id,
            'client_id'       => $client3->id,
            'budget_number'   => 'ORÇ-' . date('Y') . '-001',
            'client_name'     => $client3->name,
            'client_cpf_cnpj' => $client3->cpf_cnpj,
            'client_address'  => $client3->address,
            'status'          => 'sent',
            'valid_days'      => 10,
            'discount_type'   => 'money',
            'discount_sign'   => 'discount',
            'discount_value'  => 0,
            'notes'           => '',
        ]);

        BudgetItem::create(['budget_id' => $budget3->id, 'description' => 'Reforma completa – cozinha', 'quantity' => 1.000, 'unit_price' => 8500.00, 'sort_order' => 0]);
        BudgetItem::create(['budget_id' => $budget3->id, 'description' => 'Instalação hidráulica', 'quantity' => 1.000, 'unit_price' => 1200.00, 'sort_order' => 1]);
    }
}
