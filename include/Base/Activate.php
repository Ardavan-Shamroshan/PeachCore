<?php

/**
 * @package ArdavanPlugin
 */

namespace Inc\Base;

class Activate {
	public static function activate() {
		flush_rewrite_rules();

		// if there was no option with the given key, update the key with an empty array
		if ( ! get_option( 'peach_core_plugin' ) ) {
			update_option( 'peach_core_plugin', [] );
		}

		if ( ! get_option( 'peach_core_plugin_cpt' ) ) {
			update_option( 'peach_core_plugin_cpt', [] );
		}
	}
}