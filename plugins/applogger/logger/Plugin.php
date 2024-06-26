<?php namespace AppLogger\Logger;

use Backend;
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

    public $require = ["AppUser.User"];

    public function pluginDetails()
    {
        return [
            'name' => 'Logger',
            'description' => 'No description provided yet...',
            'author' => 'AppLogger',
            'icon' => 'icon-leaf',
            'require' => 'AppUser.User'
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
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppLogger\Logger\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return [
            'applogger.logger.access_logs' => [
                'tab' => 'Logger',
                'label' => 'View the Logs',
                'roles' => ['admin', 'publisher']

            ],
            'applogger.logger.manage_logs' => [
                'tab' => 'Logger',
                'label' => 'Manage the Logs',
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
            'logger' => [
                'label' => 'Logs',
                'url' => Backend::url('applogger/logger/logs'),
                'icon' => 'icon-clock',
                'permissions' => ['applogger.logger.*'],
                'order' => 500,
            ],
        ];
    }
}
