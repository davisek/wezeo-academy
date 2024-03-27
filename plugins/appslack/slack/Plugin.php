<?php namespace AppSlack\Slack;

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
            'name' => 'Slack',
            'description' => 'No description provided yet...',
            'author' => 'AppSlack',
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
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppSlack\Slack\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'appslack.slack.some_permission' => [
                'tab' => 'Slack',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return [
            'slack' => [
                'label' => 'Emojis',
                'url' => Backend::url('appslack/slack/emojis'),
                'icon' => 'icon-smile-o',
                'permissions' => ['appslack.slack.*'],
                'order' => 500,
            ],
        ];
    }
}
