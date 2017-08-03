<?php

/**
 * Interface Whip_DismissStorage.
 */
interface Whip_DismissStorage {

	/**
	 * Saves the value.
	 *
	 * @param int $dismissedValue The value to save.
	 *
	 * @return bool True when successful.
	 */
	public function set( $dismissedValue );

	/**
	 * Returns the value.
	 *
	 * @return int
	 */
	public function get();

}
