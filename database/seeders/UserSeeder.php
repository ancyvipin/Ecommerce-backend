<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Use firstOrCreate to make this seeder safe to run multiple times.
        User::firstOrCreate(
            ['user_email' => 'test@example.com'],
            [
                'user_name' => 'Test User',
                'user_password' => Hash::make('password'),
    
                'mobile' => '123-456-7890',
                'shipping_address_line_1' => '123 Test St',
                'shipping_city' => 'Testville',
                'shipping_state' =>'my state',
                'shipping_postal_code' => '12345',      
                'shipping_country'=>'my countrty',
            ]
        );

        // Create 20 additional random users
        User::factory(20)->create();

        $this->command->info('Seeded a test user and 20 random users.');
    }
}