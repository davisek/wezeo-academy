<?php namespace AppAuth\Auth;

use Backend;
use RainLab\User\Models\User;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Auth',
            'description' => 'No description provided yet...',
            'author' => 'AppAuth',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        User::extend(function($model) {
            $model->addFillable([
                'token'
            ]);
        });
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppAuth\Auth\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'appauth.auth.some_permission' => [
                'tab' => 'Auth',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'auth' => [
                'label' => 'Auth',
                'url' => Backend::url('appauth/auth/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['appauth.auth.*'],
                'order' => 500,
            ],
        ];
    }
}
