<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Users
      $this->call(UsersTableSeeder::class);

      // Categories
      $this->call(CategoryTableSeeder::class);

      // Roles
      $this->call(RolesAndPermissionsSeeder::class);
    }
}
