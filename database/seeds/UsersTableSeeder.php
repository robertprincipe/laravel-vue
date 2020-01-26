<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Maick',
            'email' => 'maick@sertika.com',
            'password' => bcrypt('12345678'),
            'type' => 'admin'
        ]);
    }
}
