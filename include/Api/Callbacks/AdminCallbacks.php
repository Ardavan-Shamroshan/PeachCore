<?php

namespace Inc\Api\Callbacks;

use Inc\Controllers\BaseController;

class AdminCallbacks extends BaseController {
	/**
	 * add_menu_page, add_submenu_page callbacks
	 */
	public function admin_dashboard() {
		return require_once $this->plugin_path . 'templates/admin.php';
	}

	public function custom_post_type() {
		return require_once $this->plugin_path . 'templates/post-type.php';
	}

	public function custom_taxonomy_type() {
		return require_once $this->plugin_path . 'templates/taxonomy-type.php';
	}

	public function custom_widget_type() {
		return require_once $this->plugin_path . 'templates/widget-type.php';
	}
}