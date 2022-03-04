<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use Orchid\Support\Facades\Dashboard;

class RoleSeeder extends Seeder
{
    /**
     * Роли
     *
     * @return void
     */
    public function run()
    {
        $this->prepareTables();
        $allPermissions = $this->allPermission();
        $this->allPermissionAdminPanel($allPermissions);
        $this->allPermissionApi($allPermissions);
    }

    /**
     * Подготовка таблиц
     *
     * @return void
     */
    public function prepareTables(): void
    {
        DB::table('role_users')->truncate();
        DB::table('role_client_applications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * Добавить права
     *
     * @return array
     */
    public function allPermission(): array
    {
        $allPermissions = Dashboard::getAllowAllPermission()->all();
        Role::create([
            'name' => 'Полный доступ к панели и Api',
            'slug' => 'admin',
            'permissions' => $allPermissions,
        ]);
        return $allPermissions;
    }

    /**
     * @param array $allPermissions
     * @return void
     */
    public function allPermissionAdminPanel(array $allPermissions): void
    {
        $allPlatform = array_filter($allPermissions, function ($k) {
            return str_starts_with($k, 'platform.');
        }, ARRAY_FILTER_USE_KEY);
        Role::create([
            'name' => 'Полный доступ к панели',
            'slug' => 'platform.admin',
            'permissions' => $allPlatform
        ]);
    }

    /**
     * @param array $allPermissions
     * @return void
     */
    public function allPermissionApi(array $allPermissions): void
    {
        $allApi = array_filter($allPermissions, function ($k) {
            return str_starts_with($k, 'api.');
        }, ARRAY_FILTER_USE_KEY);
        Role::create([
            'name' => 'Полный доступ к Api',
            'slug' => 'api.admin',
            'permissions' => $allApi
        ]);
    }
}

