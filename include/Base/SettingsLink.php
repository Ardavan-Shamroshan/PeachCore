<?php

namespace Inc\Base;

class SettingsLink extends BaseController {
	public function register() {
		add_filter("plugin_action_links_$this->plugin", [$this, 'settings_link']);
	}

	public function settings_link( $links ) {
		$settings_link = "<a href='admin.php?page=peach-core'>تنظیمات</a>";
		$links[]       = $settings_link;

		return $links;
	}

}