<?php

namespace Database\Seeders\OneCExchange;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Создаёт пользователя для обмена с 1С
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail(env('ONE_C_EMAIL'))->get()->first();
        if(!$user) {
            $user = new User();
        }

        $user->name = env('ONE_C_NAME');
        $user->email = env('ONE_C_EMAIL');
        $user->password = Hash::make(env('ONE_C_PASSWORD'));

        $user->save();
    }
}
