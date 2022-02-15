<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Права на доступ к данным и к админке
     *
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        $dashboard->registerPermissions(
            ItemPermission::group('Доступы к админке')
                ->addPermission('platform.dashboard', 'Общий доступ к панели пдминистратора')
                ->addPermission('platform.systems.users', 'Управление пользователями')
                ->addPermission('platform.systems.roles', 'Управление ролями')
        );

        $dashboard->registerPermissions(
            ItemPermission::group('Управление данными через админку')
                ->addPermission('platform.client_applications.manage', 'Управление приложениями')
                ->addPermission('platform.articles.manage', 'Управление статьями')
                ->addPermission('platform.authors.manage', 'Управление авторами')
        );

        $dashboard->registerPermissions(
            ItemPermission::group('Управление данными через Api')
                ->addPermission('api.client_applications.view', 'Просмотр приложений')
                ->addPermission('api.articles.manage', 'Управление статьями')
                ->addPermission('api.authors.manage', 'Управление авторами')
        );
    }
}
