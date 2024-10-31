<?php
/**
 * Plugin Name: Qbop
 * Plugin URI: https://www.qbop.com/
 * Description: Website traffic tracking, turn leads into sales.
 * Version: 1.0.0
 * Author: Web Wizards
 * Author URI: http://www.webwizards.ca/
 * License: GPL2
 */

add_action('admin_menu', 'qbop_plugin_menu');

function qbop_plugin_menu() {
	add_menu_page('Qbop Plugin Settings', 'Qbop', 'administrator', 'qbop-plugin-settings', 'qbop_plugin_settings_page', 'dashicons-admin-generic');
	add_action( 'admin_init', 'qbop_plugin_settings' );
}

function qbop_plugin_settings() {
	register_setting( 'qbop-plugin-settings-group', 'qbop_tracker_id' );
}

add_action( 'admin_init', 'qbop_plugin_settings' );

function qbop_plugin_settings_page() {
	if (!current_user_can('manage_options')) {
      		wp_die( __('You do not have sufficient permissions to access this page.') );
    	}
?>
	<div class="wrap">
		<h2>Qbop</h2>
		<form method="post" action="options.php">
    			<?php settings_fields( 'qbop-plugin-settings-group' ); ?>
    			<?php do_settings_sections( 'qbop-plugin-settings-group' ); ?>
			<hr />
			<h4>If you do not know your Qbop tracker id or you if you need to setup an account, <a href="//www.qbop.com/" target="_blank">click here</a>.
    			<table class="form-table">
        			<tr valign="top">
        				<th scope="row">Qbop Tracker Id</th>
        				<td><input type="text" name="qbop_tracker_id" value="<?php echo esc_attr( get_option('qbop_tracker_id') ); ?>" /></td>
        			</tr>
    			</table>    
    			<?php submit_button(); ?>
		</form>
	</div>
<?php }

add_action( 'wp_footer', 'qbop_script' );

function qbop_script() {
	wp_enqueue_script('qbop-tracker-min', '//www.qbop.com/tracker.min.js', array(), '3', true);
	wp_enqueue_script( 'my-script', plugin_dir_url( __FILE__ ) . '/js/qbop-script.js', array( 'jquery' ), '1.0', true );

	$qbop_id= esc_attr( get_option( 'qbop_tracker_id' ) );
?>
	<script>
		var qbopId = "<?php echo $qbop_id ?>";
	</script>
<?php }


