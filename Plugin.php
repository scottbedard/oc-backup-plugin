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
        $this->registerConsoleCommand('backup.run', 'Spatie\Backup\Commands\BackupCommand');
        $this->registerConsoleCommand('backup.cleanup', 'Spatie\Backup\Commands\CleanupCommand');
        $this->registerConsoleCommand('backup.list', 'Spatie\Backup\Commands\ListCommand');
        $this->registerConsoleCommand('backup.monitor', 'Spatie\Backup\Commands\MonitorCommand');
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
        return [
            'bedard.backup.access_settings' => [
                'tab' => 'Backup',
                'label' => 'Manage backup settings'
            ],
        ];
    }

    /**
     * Register settings model.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'class' => 'Bedard\Backup\Models\Settings',
                'description' => 'Manage automatic backups',
                'icon' => 'icon-database',
                'label' => 'Manage Backups',
                'order' => 500,
                'permissions' => [
                    'bedard.backup.access_settings',
                ],
            ],
        ];
    }
}
