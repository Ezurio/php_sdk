<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testENISetAddress()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetAddress("lo","127.0.0.1"));
	}

	public function testENIClearProperty()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty("lo","address"));
	}
}
?>
