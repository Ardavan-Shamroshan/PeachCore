<?php

namespace Inc\Controllers;

use Inc\Api\Widgets\MediaWidget;

class WidgetController extends BaseController {
	public function register() {
		if ( ! $this->activated( 'media_widget' ) ) {
			return;
		}

		(new MediaWidget)->register();
	}




}