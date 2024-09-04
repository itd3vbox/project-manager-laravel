<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Database\Seeders\ProjectSeeder as ProjectSeeder;
use Database\Seeders\TaskSeeder as TaskSeeder;
use Database\Seeders\AutomateSeeder as AutomateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Demo User 1',
            'email' => 'user1@pm.demo',
            'password' => Hash::make('123456'),
            'username' => 'user1',
        ]);

        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
            AutomateSeeder::class,
        ]);
    }
}
