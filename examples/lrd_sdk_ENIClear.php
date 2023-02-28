<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "lo";
	$address = "127.0.0.10";
	$result = LRD_ENI_SetAddress($interface, "127.0.0.1");

	if ($result == SDCERR_SUCCESS) {

		$result = LRD_ENI_ClearProperty($interface, "address");

		if ($result == SDCERR_SUCCESS) {
			print "Successfully cleared property\n";
		} else {
			print "Failed to set clear property\n";
		}
	} else {
		print "Failed to set address\n";
	}

} else{
	print"\nENI File does not exist";
}
print"\n";
?>
