<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Marco',
            'last_name' => 'Antonio',
            'email' => 'marco@mail.com',
        ]);

        User::factory()->create([
            'first_name' => 'Usuario',
            'last_name' => 'de testes',
            'email' => 'teste@mail.com',
        ]);
        User::factory(71)->create();
    }
}
