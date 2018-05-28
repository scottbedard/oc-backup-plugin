# oc-backup-plugin

Automatically back up your October applications.

> **Warning:** This plugin is a work in progress, and is not ready for production use.

### Configuration

This plugin integrates the `spatie/laravel-backup` package with October. To configure your backups, create a `backup.php` config file. [See documentation here](https://docs.spatie.be/laravel-backup/v5/installation-and-setup#basic-installation) for more information on what this file can configure.

### Scheduling backups

To schedule automatic backups, see the October settings area and click the `Backsups` tab. For this feature to work, make sure that [task scheduling](https://octobercms.com/docs/plugin/scheduling) is properly configured.
