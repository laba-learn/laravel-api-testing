<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

       // Create admin
        User::create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('12345678'),
        ]); 

        // Create other
        factory(User::class, 9)->create();
    }
}
