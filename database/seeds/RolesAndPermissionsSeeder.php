<?php

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the admin role
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);

        $user = DB::table('users')->where('username', 'jorge')->first();
        $role = DB::table('roles')->where('name', 'admin')->first();

        // Make jorge user admin
        DB::table('role_user')->delete();
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id
        ]);
    }
}
