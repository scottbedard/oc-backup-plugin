<?php namespace Bedard\Backup;

use Backend;
use System\Classes\PluginBase;

/**
 * Backup Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Backup',
            'description' => 'Automatically back up your October application',
            'author'      => 'Scott Bedard',
            'icon'        => 'icon-database'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'bedard.backup.access_backups' => [
                'tab' => 'Backup',
                'label' => 'Manage backups'
            ],
        ];
    }
}
