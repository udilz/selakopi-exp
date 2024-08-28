<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator              =   new \App\Models\User;
        $administrator->name        =   'Administrator';
        $administrator->email       =   'administrator@gmail.com';
        $administrator->roles       =   'Admin';
        $administrator->password    =   bcrypt('administrator@gmail.com');
        $administrator->save();
        $this->command->info('User Admin Berhasil Di Insert !');
    }
}
