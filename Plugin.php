<?php namespace Bedard\Backup;

use Backend;
use Bedard\Backup\Models\Settings;
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
            'description' => 'Automatically back up your October application.',
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
     * Register scheduled tasks.
     * 
     * @return void
     */
    public function registerSchedule($schedule)
    {
        // do nothing if backups aren't enabled
        if (!Settings::get('is_enabled', false)) return;

        // get our scheduling configuration
        $scope = Settings::get('scope', 'everything'); // db, files, everything
        $frequency = Settings::get('frequency', 'daily'); // daily, weekly, monthly
        $time = explode(' ', Settings::get('time', '0000-00-00 00:00:00'))[1];

        // determine what the backup command should be
        $cmd = 'backup:run';
        if ($scope === 'db') $cmd = 'backup:run --only-db';
        elseif ($scope === 'files') $cmd = 'backup:run --only-files';

        // schedule the backup command
        $backup = $schedule->command($cmd);

        if ($frequency === 'daily') {
            $schedule->command('backup:clean')->daily()->at($time);
            $backup->daily()->at($time);
        } else if ($frequency === 'weekly') {
            $schedule->command('backup:clean')->weekly();
            $backup->weekly();
        } else if ($frequency === 'monthly') {
            $schedule->command('backup:clean')->monthly();
            $backup->monthly();
        }

        // ping the heartbeat url if one was provided
        $heartbeatUrl = trim(Settings::get('heartbeat_url', ''));

        if ($heartbeatUrl) {
            $backup->thenPing($heartbeatUrl);
        }
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
                'description' => 'Manage automated backup settings.',
                'icon' => 'icon-database',
                'label' => 'Backups',
                'order' => 500,
                'permissions' => [
                    'bedard.backup.access_settings',
                ],
            ],
        ];
    }
}
