<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testENINatEnable()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_EnableNat("usb0"));
	}

	public function testENINatDisable()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_DisableNat("usb0"));
	}
}
?>
