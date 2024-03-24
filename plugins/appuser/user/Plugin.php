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
        require_once __DIR__ . '/routes.php';
        $this->app->view->addNamespace('appuser.user', base_path() . '/plugins/appuser/user/resources/views');
        $this->extendFormFields();
    }

    public function extendFormFields()
    {
        Event::listen('backend.form.extendFields', function($widget) {
            if (!$widget->getController() instanceof \AppUser\User\Http\Controllers\UsersController) {
                return;
            }

            if (!$widget->model instanceof \AppUser\User\Models\User) {
                return;
            }

            // Customize the form fields here
            $widget->addFields([
                'password' => [
                    'type' => 'password',
                    'label' => 'Password',
                    'span' => 'full',
                    'tab' => 'AppUser.User::lang.user.tab.settings',
                ],
                'password_confirmation' => [
                    'type' => 'password',
                    'label' => 'Password Confirmation',
                    'span' => 'full',
                    'tab' => 'AppUser.User::lang.user.tab.settings',
                ],
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
            'AppUser\User\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        //return []; // Remove this line to activate

        return [
            'appuser.user.access_users' => [
                'tab' => 'User',
                'label' => 'Access Users'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        // return []; // Remove this line to activate

        return [
            'user' => [
                'label' => 'User',
                'url' => Backend::url('appuser/user/users'),
                'icon' => 'icon-leaf',
                'permissions' => ['appuser.user.*'],
                'order' => 500,

                // Submenu items
                'sideMenu' => [
                    'users' => [
                        'label'       => 'Manage Users',
                        'icon'        => 'icon-user',
                        'url'         => Backend::url('appuser/user/users'),
                        'permissions' => ['appuser.user.access_users'],
                    ],
                ]
            ],
        ];
    }
}
