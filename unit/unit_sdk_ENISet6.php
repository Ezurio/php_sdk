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

	public function testENI_SetMethod6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetMethod6("eth99", "static"));
	}

	public function testENI_SetAddress6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetAddress6("eth99", "2001:db8::1"));
	}

	public function testENI_SetNetmask6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetNetmask6("eth99", "64"));
	}

	public function testENI_SetGateway6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetGateway6("eth99", "2001:db8::2"));
	}

	public function testENI_SetNameserver6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetNameserver6("eth99", "2001:db8::10"));
	}

	public function testENI_SetDhcp6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_SetDhcp6("eth99", "stateless"));
	}

	public function testENI_DisableInterface6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_DisableInterface6("eth99"));
	}

	public function testENI_EnableInterface6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_EnableInterface6("eth99"));
	}

	public function testENI_ClearAddress6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty6("eth99",LRD_ENI_PROPERTY_ADDRESS));
	}

	public function testENI_ClearNetmask6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty6("eth99",LRD_ENI_PROPERTY_NETMASK));
	}

	public function testENI_ClearGateway6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty6("eth99",LRD_ENI_PROPERTY_GATEWAY));
	}

	public function testENI_ClearNameserver6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty6("eth99",LRD_ENI_PROPERTY_NAMESERVER));
	}

	public function testENI_ClearDHCP6()
	{
		$this->assertEquals(SDCERR_SUCCESS, LRD_ENI_ClearProperty6("eth99",LRD_ENI_PROPERTY_DHCP));
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
