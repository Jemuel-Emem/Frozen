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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'ADMIN',
            'contactnumber' => 'baras',
            'address' => 'baras',
            'platenumber' => '122121',
           'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
           'role' => 1,
        ]);


        User::create([
            'name' => 'no-rider selected',
            'contactnumber' => 'baras',
            'address' => 'baras',
            'platenumber' => '122121',
           'email' => 'rider@gmail.com',
        'password' => bcrypt('password'),
           'role' => 2,
        ]);

        User::create([
            'name' => 'TEST',
            'contactnumber' => 'baras',
            'address' => 'baras',
            'platenumber' => '122121',
           'email' => 'test@gmail.com',
        'password' => bcrypt('password'),
           'role' => 0,
        ]);
    }
}
