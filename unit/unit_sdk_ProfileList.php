<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetCurrentConfig()
	{
		$currentConfig = str_repeat(" ",CONFIG_NAME_SZ);
		$this->assertEquals(SDCERR_SUCCESS, GetCurrentConfig(NULL, $currentConfig));
	}

	public function testGetNumConfigs()
	{
		$Count = new_ulongp();
		$this->assertEquals(SDCERR_SUCCESS, GetNumConfigs($Count));

		return $Count;
	}

	/**
	* @depends testGetNumConfigs
	*/

	public function testGetAllConfigs($Count)
	{
		$cfgs = new_SDCConfig_array(ulongp_value($Count));
		$this->assertEquals(SDCERR_SUCCESS, GetAllConfigs($cfgs, $Count));
		delete_ulongp($Count);
		delete_SDCConfig_array($cfgs);
	}

}

?>