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
        DB::table('users')->delete();
        DB::table('users')->insert([
            'name' => 'Jorge Vivas',
            'email' => 'jorge@paralideres.org',
            'password' => bcrypt('test123'),
        ]);
        factory(App\User::class, 50)->create();
    }
}
