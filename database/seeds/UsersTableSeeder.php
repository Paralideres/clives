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
            'username' => 'jorge',
            'email' => 'jorge@paralideres.org',
            'password' => bcrypt('test123'),
            'verified' => true
        ]);

        $user = DB::table('users')->where('username', 'jorge')->first();

        DB::table('user_profiles')->delete();
        DB::table('user_profiles')->insert([
            'user_id' => $user->id
        ]);

        factory(App\User::class, 50)->create()->each(function($u) {
            $u->profile()->save(factory(App\UserProfile::class)->make());
        });
    }
}
