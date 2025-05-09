<?php

namespace Cores\Traits;

\defined( 'ABSPATH' ) || die;

/**
 * Singleton base class for having singleton implementation
 * This allows you to have only one instance of the needed object
 * You can get the instance with $class = My_Class::get_instance();
 *
 * /!\ The get_instance method have to be implemented !
 */
trait Singleton {

	/**
	 * @var self
	 */
	protected static $instance;

	/**
	 * @return self
	 */
	final public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new static;
		}

		return self::$instance;
	}

	/**
	 * Constructor protected from the outside
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Add init function by default
	 * Implement this method in your child class
	 * If you want to have actions send at construct
	 */
	protected function init(): void {}

	/**
	 * prevent the instance from being cloned
	 *
	 * @return void
	 */
	final public function __clone() {}

	/**
	 * prevent from being unserialized
	 *
	 * @return void
	 */
	final public function __wakeup() {}
}
