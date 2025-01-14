<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Data Entry User',
            'email' => 'data_entry@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('data'), 
            'role' => 'data_entry', 
        ]);

        User::factory()->create([
            'name' => 'Loan Handler User',
            'email' => 'loan_handler@example.com',
            'password' => bcrypt('loan'), 
            'role' => 'loan_handler', 
        ]);

        User::factory()->create([
            'name' => 'Collector User',
            'email' => 'collector@example.com',
            'password' => bcrypt('collector'), 
            'role' => 'loan_collector', 
        ]);
    }
}
