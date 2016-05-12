<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            "name" => "Bede Gaming",
            "email" => "developers@bedegaming.com",
            "password" => bcrypt("password"),
            "api_token" => str_random(60),
            "remember_token" => str_random(10),
            "admin" => true,
        ]);

        factory(App\User::class, 25)->create();
    }
}
