<?php namespace AppUser\User\Updates\Seeders;

use AppUser\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Seeder;

/**
 * SeedUsersTable
 */
class SeedUsersTable extends Seeder
{
    /**
     * run the database seeds.
     */
    public function run()
    {
        User::create([
            'username' => 'David',
            'password' => bcrypt('David'),
            'token' => null
        ]);
        User::create([
            'username' => 'Admin',
            'password' => bcrypt('Admin'),
            'token' => null
        ]);
    }
}
