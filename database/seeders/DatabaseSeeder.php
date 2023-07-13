<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'=>'Hajatiana',
            'firstname'=>'Roberto',
            'email'=>'super-admin@cci.com',
            'civility'=>'Mr',
            'status'=>true,
            'mobile'=>'0346628361',
            'phone'=>'0346628361',
            'password'=> Hash::make('superadmin'),
            'role'=>'admin'
        ]);
    }
}
