<?php

/**
 * @package ArdavanPlugin
 */

namespace Inc\Base;

class Activate {
	public static function activate() {
		flush_rewrite_rules();

		if ( get_option( 'peach_core_plugin' ) ) {
			return;
		}

		update_option( 'peach_core_plugin', [] );
	}
}