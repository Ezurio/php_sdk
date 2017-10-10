<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetDefaultRoute()
	{
		//Interface can be null, first default route found will be returned
		$interface = null;
		$DefaultRoute = new DEFAULT_ROUTE();
		$this->assertEquals(SDCERR_SUCCESS, LRD_WF_GetDefaultRoute($DefaultRoute, LRD_ROUTE_FILE, $interface));
	}
}

?>