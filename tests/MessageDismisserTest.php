<?php
/**
 * WHIP libary test file.
 *
 * @package Yoast\WHIP
 */

/**
 * Message Dismisser unit tests.
 */
class MessageDismisserTest extends PHPUnit_Framework_TestCase {

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		require_once dirname( __FILE__ ) . '/doubles/Whip_DismissStorageMock.php';
		require_once dirname( __FILE__ ) . '/doubles/WPCoreFunctionsMock.php';
	}

	/**
	 * @covers Whip_MessageDismisser::__construct()
	 * @covers Whip_MessageDismisser::dismiss()
	 */
	public function testDismiss() {
		$currentTime = time();
		$storage     = new Whip_DismissStorageMock();
		$dismisser   = new Whip_MessageDismisser( $currentTime, ( WEEK_IN_SECONDS * 4 ), $storage );

		$this->assertEquals( 0, $storage->get() );

		$dismisser->dismiss();

		$this->assertEquals( $currentTime, $storage->get() );
	}

	/**
	 * @dataProvider versionNumbersProvider
	 *
	 * @param int  $savedTime   The saved time.
	 * @param int  $currentTime The current time.
	 * @param bool $expected    The expected value.
	 *
	 * @covers Whip_MessageDismisser::__construct()
	 * @covers Whip_MessageDismisser::isDismissed()
	 */
	public function testIsDismissibleWithVersions( $savedTime, $currentTime, $expected ) {
		$storage = new Whip_DismissStorageMock();
		$storage->set( $savedTime );
		$dismisser = new Whip_MessageDismisser( $currentTime, ( WEEK_IN_SECONDS * 4 ), $storage );

		$this->assertEquals( $expected, $dismisser->isDismissed() );
	}

	/**
	 * Provides array with test values.
	 *
	 * @return array
	 */
	public function versionNumbersProvider() {
		return array(
			array( strtotime( '-2weeks' ), time(), true ),
			array( strtotime( '-4weeks' ), time(), true ),
			array( strtotime( '-6weeks' ), time(), false ),
			array( time(), time(), true ),
		);
	}
}
