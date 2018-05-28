<?php namespace Bedard\Backup\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{
    /**
     * @var array Behaviors implemented by this model.
     */
    public $implement = [
        'System.Behaviors.SettingsModel',
    ];

    /**
     * @var string Unique settings code.
     */
    public $settingsCode = 'bedard_backup_settings';

    /**
     * @var string Form Fields.
     */
    public $settingsFields = 'fields.yaml';
}

