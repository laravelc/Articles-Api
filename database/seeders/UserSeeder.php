<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Пользователи
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            User::create([
                'name' => 'Админ',
                'email' => 'admin@admin.ru',
                'password' => Hash::make('secret12345'),
            ]);
        }
        $superadmin = \Orchid\Platform\Models\User::where('id', 1)->first();
        $superadmin->addRole(Role::where('slug', 'admin')->first());
    }
}
