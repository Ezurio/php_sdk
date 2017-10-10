<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

const BUFSIZE = 100;

class StackTest extends PHPUnit_Framework_TestCase
{

	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetInterface()
	{
		if(file_exists('/etc/network/interfaces')){
			$interface = "eth99";
		}
		$this->assertEquals(true, $interface != NULL);

		return $interface;
	}

	/**
	* @depends testGetInterface
	*/

	public function testGetAutoStart($interface)
	{
		$autoStart = new_intp();

		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_GetAutoStart($interface,$autoStart));

		delete_intp($autoStart);
	}

	/**
	* @depends testGetInterface
	*/

	public function testGetMethod($interface)
	{
		$method = str_repeat(" ",BUFSIZE);

		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_GetMethod($interface,$method,BUFSIZE));
	}

	/**
	* @depends testGetInterface
	*/

	public function testGetMethod6($interface)
	{
		$method = str_repeat(" ",BUFSIZE);

		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_GetMethod6($interface,$method,BUFSIZE));
	}
}

?>