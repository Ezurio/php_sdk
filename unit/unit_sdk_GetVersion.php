<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetSDKVersion()
	{
		$SDKVersion = new_ulongp();
		$this->assertEquals(SDCERR_SUCCESS, GetSDKVersion($SDKVersion));
	}

	public function testGetRadioChipSet()
	{
		$rcs = new_RADIOCHIPSETp();
		$this->assertEquals(SDCERR_SUCCESS, LRD_WF_GetRadioChipSet($rcs));
	}

	public function testGetCurrentStatus()
	{
		$status = new CF10G_STATUS();
		$this->assertEquals(SDCERR_SUCCESS, GetCurrentStatus($status));
	}
}

?>