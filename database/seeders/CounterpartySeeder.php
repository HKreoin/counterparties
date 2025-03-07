<?php

namespace Database\Seeders;

use App\Models\Counterparty;
use App\Models\User;
use Illuminate\Database\Seeder;

class CounterpartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Создаем 10 контрагентов, связанных с существующими пользователями
        User::all()->each(function ($user) {
            Counterparty::factory()
                ->count(20) // По 2 контрагента на каждого пользователя
                ->create([
                    'user_id' => $user->id
                ]);
        });
    }
}
