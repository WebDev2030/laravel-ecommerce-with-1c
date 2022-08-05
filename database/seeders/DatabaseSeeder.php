<?php

namespace Database\Seeders;

use http\Env;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new \App\Models\User();
        $user->name = env('1C_NAME');
        $user->email = env('1C_EMAIL');
        $user->password = Hash::make(env('1C_PASSWORD'));
        $user->save();
    }
}
