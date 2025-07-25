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
        $this->call([
        	RolePermissionSeeder::class,
    	]);

        \App\Models\User::factory(100)->create();

        $user = User::find(1); 
        $user->assignRole('HR');
        $user->givePermissionTo('Creator');

        $user2 = User::find(2); 
        $user2->assignRole('HR');
        $user2->givePermissionTo('Manager');

        $user3 = User::find(3); 
        $user3->assignRole('IT');
        $user3->givePermissionTo('Accountant');

        $user4 = User::find(4); 
        $user4->assignRole('IT');
        $user4->givePermissionTo('Administrator');
    }
}
