<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $company1 = Company::where('cnpj', '12.345.678/0001-90')->first();
        $company2 = Company::where('cnpj', '98.765.432/0001-10')->first();

        User::create([
            'company_id' => $company1->id,
            'name'       => 'Admin Gesso Pro',
            'email'      => 'admin@gessopro.com.br',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
        ]);

        User::create([
            'company_id' => $company2->id,
            'name'       => 'Admin Silva Reformas',
            'email'      => 'admin@silvareformas.com.br',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
        ]);
    }
}
