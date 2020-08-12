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
        DB::table('users')->insert([
            'name' => 'Boukarta Alex',
            'email' => 'rekhichem@gmail.com',
            'password' => bcrypt('tigzirt45T'),
        ]);

        DB::table('users')->insert([
            'name' => 'Kardos Crèdis',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('tigzirt45T'),
        ]);

        DB::table('accounts')->insert([
            'user_id' => 1,
            'name' => 'Random Person',
            'card_number' => '1234567812345678',
            'type' => 'Visa Card',
            'ccv' => 'Visa Card',
            'exp' => '02/21',
            'sold' => 45030.00,
        ]);

        DB::table('accounts')->insert([
            'user_id' => 1,
            'name' => 'Peter Jordasson',
            'card_number' => '7812567312345648',
            'type' => 'Visa Card',
            'ccv' => 'Visa Card',
            'exp' => '02/21',
            'sold' => 30450.00,
        ]);

        DB::table('accounts')->insert([
            'user_id' => 2,
            'name' => 'Saager Dutsoorn',
            'card_number' => '7812567312345648',
            'type' => 'Visa Card',
            'ccv' => 'Visa Card',
            'exp' => '07/23',
            'sold' => 50340.00,
        ]);
    }
}