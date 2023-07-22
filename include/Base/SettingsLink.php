<?php

namespace Inc\Base;

class SettingsLink extends BaseController {
//	protected $plugin;
//	public function __construct() {
//		$this->plugin = ARDAVAN;
//	}

	public function register() {
		add_filter("plugin_action_links_$this->plugin", [$this, 'settings_link']);
	}

	public function settings_link( $links ) {
		$settings_link = "<a href='admin.php?page=ardavan-plugin'>Settings</a>";
		$links[]       = $settings_link;

		return $links;
	}

}