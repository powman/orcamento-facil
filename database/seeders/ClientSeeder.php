<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('cnpj', '12.345.678/0001-90')->first();
        $company2 = Company::where('cnpj', '98.765.432/0001-10')->first();

        $clients1 = [
            ['name' => 'João da Silva', 'cpf_cnpj' => '123.456.789-00', 'phone' => '(11) 98888-1111', 'email' => 'joao@email.com', 'address' => 'Rua A, 100 – Bela Vista, SP'],
            ['name' => 'Maria Oliveira', 'cpf_cnpj' => '987.654.321-00', 'phone' => '(11) 97777-2222', 'email' => 'maria@email.com', 'address' => 'Av. B, 200 – Moema, SP'],
            ['name' => 'Construtora ABC Ltda', 'cpf_cnpj' => '11.222.333/0001-44', 'phone' => '(11) 3000-5555', 'email' => 'contato@abc.com.br', 'address' => 'Rua C, 300 – Pinheiros, SP'],
        ];

        foreach ($clients1 as $data) {
            Client::create(array_merge($data, ['company_id' => $company1->id]));
        }

        $clients2 = [
            ['name' => 'Pedro Alves', 'cpf_cnpj' => '111.222.333-44', 'phone' => '(21) 96666-3333', 'email' => 'pedro@email.com', 'address' => 'Rua D, 10 – Copacabana, RJ'],
            ['name' => 'Ana Lima', 'cpf_cnpj' => '555.666.777-88', 'phone' => '(21) 95555-4444', 'email' => 'ana@email.com', 'address' => 'Av. E, 50 – Ipanema, RJ'],
        ];

        foreach ($clients2 as $data) {
            Client::create(array_merge($data, ['company_id' => $company2->id]));
        }
    }
}
