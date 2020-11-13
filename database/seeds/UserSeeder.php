<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Christopher Vistal',
            'email' => 'chris@yahoo.com',
            'password' => app('hash')->make(1234),
        ]);
    }
}
