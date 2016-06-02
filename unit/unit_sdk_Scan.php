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
		$result = new_SDCERRp();
		SDCERRp_assign($result,SDCERR_FAIL); //Set to fail, otherwise it is initialized to success
		$numElements = new_intp();
		intp_assign($numElements,150);
		$list = lrd_php_sdk::new_LRD_WF_PHP_GetBSSIDList($numElements,$result);

		$this->assertEquals(SDCERR_SUCCESS, SDCERRp_value($result));

		lrd_php_sdk::delete_LRD_WF_PHP_GetBSSIDList($list);
		delete_intp($numElements);
		delete_SDCERRp($result);
	}
}

?>