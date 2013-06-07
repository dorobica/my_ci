<?php

class RedBeanHook {
	/* init redbean and freeze in production */

	public function __init() {
		switch(ENVIRONMENT) {
			case 'production':
				R::freeze(true);
				break;
		}
	}
}