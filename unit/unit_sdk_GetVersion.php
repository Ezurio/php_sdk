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
		delete_ulongp($SDKVersion);
	}

	public function testGetRadioChipSet()
	{
		$rcs = new_RADIOCHIPSETp();
		$this->assertEquals(SDCERR_SUCCESS, LRD_WF_GetRadioChipSet($rcs));
		delete_RADIOCHIPSETp($rcs);
	}

	public function testGetCurrentStatus()
	{
		$status = new CF10G_STATUS();
		$this->assertEquals(SDCERR_SUCCESS, GetCurrentStatus($status));
	}

	public function testLRD_WF_GetFirmwareVersionString()
	{
		$firmwareStringLength = new_intp();
		intp_assign($firmwareStringLength,80);
		$firmwareString = str_repeat(" ",intp_value($firmwareStringLength));
		$this->assertEquals(SDCERR_SUCCESS, LRD_WF_GetFirmwareVersionString($firmwareString, $firmwareStringLength));
		delete_intp($firmwareStringLength);
	}
}

?>