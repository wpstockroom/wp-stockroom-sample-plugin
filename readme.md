# WP Stockroom Sample Plugin

This is a bare minimum plugin example for a plugin to use the WP Stockroom updater.

## Required files

 - [readme.txt](readme.txt)
   - Only the _Stable tag_ is required.
   - Here is the documentation of the [readme file](https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/).
 - [class-wp-stockroom-updater.php](class-wp-stockroom-updater.php)  
   The Main stockroom updater script. It has to be included in _some_ way.
 - [MAINP-PLUGIN-FILE.php](wp-stockroom-sample-plugin.php)  
   - The _Plugin Name_ The plugin name
   - The _Update URI_ Should be set to your own hosted stockroom installation.  
     This should be your domain without `https://` and no trailing slash.  
   - The _Version_ Is required.
   - Here is a list of all (optional) [plugin headers](https://developer.wordpress.org/plugins/plugin-basics/header-requirements/).
   - Includes the `class-wp-stockroom-updater.php` script.
   - Then registers the updater.
 - [.github/workflows/deployment.yml](.github/workflows/deployment.yml)  
   The Github action that triggers when creating a new version. See the [Github action](https://github.com/wpstockroom/github-action#readme) repository for details.
 - [.distignore](.distignore)
   What files to exclude form the build plugin.zip file. Technically not needed, strongly recommended.

## Registering the updater

```php
include_once __DIR__ .'/class-wp-stockroom-updater.php'; // Include the updater script in some way.
add_filter( "update_plugins_YOURDOMAINHERE.COM", array( 'WP_Stockroom_Updater', 'check_update' ),10, 4 );
```

## Releasing a new version

When you are ready to release a new version. Do the following steps.

 - Update the _"Version"_ header in your [MAINP-PLUGIN-FILE.php](wp-stockroom-sample-plugin.php).
 - Update the _"Stable tag"_ in your [readme.txt](readme.txt).
 - Push that to Github.
 - On Github, create a new release and a new tag.  
   The default setup triggers on new release, but that can be changed in [.github/workflows/deployment.yml](.github/workflows/deployment.yml)
   by changing the [on](https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions#on).

Now in the background Github action will create a new Zip and upload that zip and the readme.txt to your own Stockroom.

## FAQ

### The update doesn't appear.
- Is the plugin active? Otherwise, it won't check for updates.
- On the wp-admin updates page is a _Check again._ Button, but this can still have a 1~2 minute cache.

## Customization.

### Customizing the slug.

By default, the updater will check the slug of your plugin folder. So in this same plugin is will look for `wp-stockroom-sample-plugin`
If you rename the plugin you will still have to point the updater to the original slug. You can change the slug during the update process.

```php
/**
 * Change the slug of the theme/plugin that is being updated.
 *
 * @param string $package_slug The current slug of the theme/plugin that is being checked.
 * @param array  $current_data Details of the plugin/theme being checked.
 */
add_filter( 'wp_stockroom_updater_slug', function ( $package_slug, $current_data ) {
	if ( empty( $current_data['Title'] ) || $current_data['Title'] !== 'WP StockRoom Sample Theme' ) {
		return $package_slug; // This a different theme or plugin. So ignore.
	}

	// Reset the slug back to the original that is uses by github-action and the wp-stockroom installation.
	return 'wp-stockroom-sample-theme';
}, 10, 3 );
```
