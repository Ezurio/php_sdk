<?php
dl("lrd_php_sdk.so"); // Load it.

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetVersion()
	{
		$versionNumH = new_ulongp();
		$this->assertEquals(0, GetSDKVersion( $versionNumH ));
	}
}

?>