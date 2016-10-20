<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testENI_AddInterface()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_AddInterface("eth99"));
	}

	public function testENI_AddInterface6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_AddInterface6("eth99"));
	}

	public function testENI_EnableNat6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_EnableNat6("eth99"));
	}

	public function testENI_DisableNat6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_DisableNat6("eth99"));
	}

	public function testENI_RemoveInterface6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_RemoveInterface6("eth99"));
	}

	public function testENI_RemoveInterface()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_RemoveInterface("eth99"));
	}
}
?>
