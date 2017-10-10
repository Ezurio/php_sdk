<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetDHCPIPv4Lease()
	{
		$interface = "eth99";
		$DHCPLease = new DHCP_LEASE();
		$this->assertEquals(SDCERR_SUCCESS, LRD_WF_GetDHCPIPv4Lease($DHCPLease, $interface));
	}
}

?>