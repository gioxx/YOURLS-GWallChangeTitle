<?php
/*
Plugin Name: GWall Change Title
Plugin URI: https://github.com/gioxx/YOURLS-GWallChangeTitle
Description: Change Yourls Title
Version: 1.0
Author: Gioxx
Author URI: https://gioxx.org
*/

/*
	Credits:
	https://github.com/YOURLS/YOURLS/blob/3438b06/user/plugins/sample-plugin/plugin.php#L38-L60
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Register config page
yourls_add_action( 'plugins_loaded', 'gwall_title_config_add_page' );
function gwall_title_config_add_page() {
	yourls_register_plugin_page( 'gwall_title_config', 'GWall Change Title Plugin Config', 'gwall_title_config_do_page' );
}

// Display config page
function gwall_title_config_do_page() {
	if( isset( $_POST['gwall_title_custom'] ) )
		gwall_title_config_update_option();
		$gwall_title_custom = yourls_get_option( 'gwall_title_custom' );
		$gwall_title_original = yourls_get_option( 'gwall_title_original' );
    if ($gwall_title_original == 1 ) { $checkbox = "checked"; } else { $checkbox = ""; }
		echo <<<HTML
			<h2>GWall Change Title Plugin Config</h2>
			<p>Put in this page the title you want to use in your YOURLS installation.</p>
			<form method="post">
				<p><label for="gwall_title_custom" style="display: inline-block; width: 100px;">Custom Title</label> <input type="text" id="gwall_title_custom" name="gwall_title_custom" value="$gwall_title_custom" size="100" /></p>
        <p><label for="gwall_title_original">Mantain <strong>(YOURLS)</strong> after custom title.</label> <input type="checkbox" id="gwall_title_original" name="gwall_title_original" value="yes" $checkbox></p>
				<p><input type="submit" value="Update values" /></p>
			</form>
			<hr style="margin-top: 40px" />
			<p><strong>Dev</strong>: Gioxx &raquo; <strong>Version</strong>: 1.0 &raquo; <strong>Revision</strong>: 20220831 &raquo; <strong>Blog</strong>: <a href="https://gioxx.org" />gioxx.org</a> &raquo; <strong>GitHub</strong>: <a href="http://github.com/gioxx/" />gh/gioxx</a><br />
			<a href="https://gfsolone.com" /><img src="https://gfsolone.com/images/gfsolone.footer.png" style="padding-top: 7px;" /></a></p>
HTML;
}

// Update options in database
function gwall_title_config_update_option() {
	$customtitle = $_POST['gwall_title_custom'];
	if( $customtitle ) {
		$customtitle = strval($customtitle);
		yourls_update_option( 'gwall_title_custom', $customtitle );
	}

  if (isset($_POST['gwall_title_original'])) {
    yourls_update_option( 'gwall_title_original', 1 );
  } else {
    yourls_update_option( 'gwall_title_original', 0 );
  }

}

// Show custom title
yourls_add_filter( 'html_title', 'yourls_change_title' );
function yourls_change_title( $value ) {
  if ( yourls_get_option( 'gwall_title_original' ) == 1 ) {
    $value = yourls_get_option( 'gwall_title_custom' ) . ' (YOURLS)';
  } else {
    $value = yourls_get_option( 'gwall_title_custom' );
  }
	return $value; // a filter *always* has to return a value
}
