<?php namespace AppUser\User;

use Backend;
use October\Rain\Support\Facades\Event;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'User',
            'description' => 'No description provided yet...',
            'author' => 'AppUser',
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
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppUser\User\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return [
            'appuser.user.access_users' => [
                'tab' => 'User',
                'label' => 'View the users.',
                'roles' => ['admin', 'publisher']
            ],
            'appuser.user.manage_users' => [
                'tab' => 'User',
                'label' => 'Manage the users.',
                'roles' => ['admin']
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return [
            'user' => [
                'label' => 'Users',
                'url' => Backend::url('appuser/user/users'),
                'icon' => 'icon-user-account',
                'permissions' => ['appuser.user.access_users'],
                'order' => 500,
            ],
        ];
    }
}
