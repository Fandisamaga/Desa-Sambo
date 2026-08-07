<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'kantordesasambo@gmail.com'],
            ['name' => 'Administrator Desa Sambo', 'password' => Hash::make('Sambo123'), 'is_admin' => true],
        );   
        $this->call([
        ProdukUmkmSeeder::class,
        ]);   
    }
}
