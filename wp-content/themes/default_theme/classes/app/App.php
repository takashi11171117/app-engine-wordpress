<?php
class App {
	private static $uniqueInstance;

	private function __construct() {
        new WpChamploo();
        Shortcode::getInstance();
        Editor::getInstance();
        Controller::getInstance();
	}

	public static function getInstance() {
		if ( ! isset( static::$uniqueInstance ) ) {
			static::$uniqueInstance = new App();
		}
		return static::$uniqueInstance;
	}
}
