<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyService;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::create([
            'name'         => 'Gesso & Acabamentos Ltda',
            'trade_name'   => 'Gesso Pro',
            'cnpj'         => '12.345.678/0001-90',
            'phone1'       => '(11) 98765-4321',
            'phone2'       => '(11) 3456-7890',
            'email'        => 'contato@gessopro.com.br',
            'website'      => 'www.gessopro.com.br',
            'address'      => 'Rua das Construções, 123',
            'neighborhood' => 'Centro',
            'city'         => 'São Paulo',
            'state'        => 'SP',
            'zip_code'     => '01310-000',
        ]);

        foreach (['Gesso', 'Drywall', 'Textura', 'Pintura', 'Elétrica', 'Reforma'] as $service) {
            CompanyService::create(['company_id' => $company1->id, 'name' => $service]);
        }

        $company2 = Company::create([
            'name'         => 'Construções & Reformas Silva ME',
            'trade_name'   => 'Silva Reformas',
            'cnpj'         => '98.765.432/0001-10',
            'phone1'       => '(21) 99876-5432',
            'phone2'       => '',
            'email'        => 'contato@silvareformas.com.br',
            'website'      => 'www.silvareformas.com.br',
            'address'      => 'Av. das Reformas, 456',
            'neighborhood' => 'Barra da Tijuca',
            'city'         => 'Rio de Janeiro',
            'state'        => 'RJ',
            'zip_code'     => '22640-100',
        ]);

        foreach (['Reforma', 'Construção', 'Hidráulica', 'Alvenaria', 'Cobertura'] as $service) {
            CompanyService::create(['company_id' => $company2->id, 'name' => $service]);
        }
    }
}
