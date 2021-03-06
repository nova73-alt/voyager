<?php

namespace Voyager\Admin;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Voyager\Admin\Classes\MenuItem;
use Voyager\Admin\Commands\InstallCommand;
use Voyager\Admin\Facades\Voyager as VoyagerFacade;
use Voyager\Admin\Http\Middleware\VoyagerAdminMiddleware;
use Voyager\Admin\Manager\Breads as BreadManager;
use Voyager\Admin\Manager\Menu as MenuManager;
use Voyager\Admin\Manager\Plugins as PluginManager;
use Voyager\Admin\Manager\Settings as SettingManager;
use Voyager\Admin\Policies\BasePolicy;

class VoyagerServiceProvider extends ServiceProvider
{
    protected $policies = [];
    protected $pluginmanager;
    protected $breadmanager;
    protected $menumanager;

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views'), 'voyager');
        $this->loadTranslationsFrom(realpath(__DIR__.'/../resources/lang'), 'voyager');

        $this->loadPluginFormfields();

        $breads = $this->breadmanager->getBreads();

        // Register menu-items
        $this->menumanager->addItems(
            (new MenuItem(__('voyager::generic.dashboard'), 'home', true))->permission('browse', ['admin'])->route('voyager.dashboard')->exact()
        );
        $this->registerBreadBuilderMenuItem($breads);
        $this->menumanager->addItems(
            (new MenuItem(__('voyager::generic.media'), 'photograph', true))->permission('browse', ['media'])->route('voyager.media'),
            (new MenuItem(__('voyager::generic.ui_components'), 'template', true))->permission('browse', ['ui'])->route('voyager.ui'),
            (new MenuItem(__('voyager::generic.settings'), 'cog', true))->permission('browse', ['settings'])->route('voyager.settings.index'),
            (new MenuItem(__('voyager::plugins.plugins'), 'puzzle', true))->permission('browse', ['plugins'])->route('voyager.plugins.index')
        );
        $this->registerBreadMenuItems($breads);

        // Register BREAD policies
        $this->registerBreadPolicies($breads);
        $this->registerPolicies();

        // Register permissions
        app(Gate::class)->before(function ($user, $ability, $arguments = []) {
            return VoyagerFacade::authorize($user, $ability, $arguments);
        });

        $router->aliasMiddleware('voyager.admin', VoyagerAdminMiddleware::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Voyager', VoyagerFacade::class);

        $this->pluginmanager = new PluginManager();
        $this->app->singleton(PluginManager::class, function () {
            return $this->pluginmanager;
        });

        $this->breadmanager = new BreadManager();
        $this->app->singleton(BreadManager::class, function () {
            return $this->breadmanager;
        });

        $this->settingmanager = new SettingManager();
        $this->app->singleton(SettingManager::class, function () {
            return $this->settingmanager;
        });

        $this->menumanager = new MenuManager($this->pluginmanager);
        $this->app->singleton(MenuManager::class, function () {
            return $this->menumanager;
        });

        $this->app->singleton('voyager', function () {
            return new Voyager($this->breadmanager, $this->pluginmanager, $this->settingmanager);
        });

        $this->settingmanager->loadSettings();

        $this->commands(InstallCommand::class);

        $this->registerFormfields();
    }

    public function registerFormfields()
    {
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Checkboxes::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\DynamicSelect::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Number::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Password::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Radios::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Relationship::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Select::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Tags::class);
        $this->breadmanager->addFormfield(\Voyager\Admin\Formfields\Text::class);
    }

    public function loadPluginFormfields()
    {
        $this->pluginmanager->getPluginsByType('formfield')->where('enabled')->each(function ($formfield) {
            $this->breadmanager->addFormfield($formfield->getFormfield());
        });
    }

    public function registerBreadPolicies($breads)
    {
        $breads->each(function ($bread) {
            $policy = BasePolicy::class;

            if (!empty($bread->policy) && class_exists($bread->policy)) {
                $policy = $bread->policy;
            }

            $this->policies[$bread->model.'::class'] = $policy;
        });
    }

    public function registerBreadBuilderMenuItem($breads)
    {
        $bread_builder_item = (new MenuItem(__('voyager::generic.bread'), 'bread', true))
                                ->permission('browse', ['breads'])
                                ->route('voyager.bread.index');

        $this->menumanager->addItems(
            $bread_builder_item
        );

        $breads->each(function ($bread) use ($bread_builder_item) {
            $bread_builder_item->addChildren(
                (new MenuItem($bread->name_plural, $bread->icon, true))->permission('edit', [$bread->table])
                    ->route('voyager.bread.edit', ['table' => $bread->table])
            );
        });
    }

    public function registerBreadMenuItems($breads)
    {
        if ($breads->count() > 0) {
            $this->menumanager->addItems(
                (new MenuItem('', '', true))->divider()
            );

            $breads->each(function ($bread) {
                $this->menumanager->addItems(
                    (new MenuItem($bread->name_plural, $bread->icon, true))->permission('browse', [$bread])
                        ->route('voyager.'.$bread->slug.'.browse')
                );
            });
        }
    }
}
