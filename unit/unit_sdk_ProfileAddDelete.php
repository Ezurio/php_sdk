<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testCreateConfig()
	{
		$cfgs = new SDCConfig();
		$this->assertEquals(SDCERR_SUCCESS, CreateConfig($cfgs));

		return $cfgs;
	}

	/**
	* @depends testCreateConfig
	*/

	public function testAddConfig($cfgs)
	{
		$profileName = "example";
		$cfgs->configName = $profileName;
		$this->assertEquals(SDCERR_SUCCESS, AddConfig($cfgs));
		free_SDCConfig($cfgs);

		return $profileName;
	}

	/**
	* @depends testAddConfig
	*/

	public function testDeleteConfigSuccess($profileName)
	{
		$this->assertEquals(SDCERR_SUCCESS, DeleteConfig($profileName));
	}

	/**
	* @depends testAddConfig
	*/

	public function testDeleteConfigInvalid($profileName)
	{
		$this->assertEquals(SDCERR_INVALID_NAME, DeleteConfig($profileName));
	}
}

?>