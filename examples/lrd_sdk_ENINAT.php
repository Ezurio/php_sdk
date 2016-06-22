<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "usb0";
	$result = LRD_ENI_EnableNat($interface);

	if ($result == SDCERR_SUCCESS) {
		print "Successfully enabled NAT\n";

		$result = LRD_ENI_DisableNat($interface);

		if ($result == SDCERR_SUCCESS) {
			print "Successfully disabled NAT\n";
		} else {
			print "Failed to disable NAT\n";
		}
	} else {
		print "Failed to enable NAT\n";
	}

} else{
	print"\nENI File does not exist";
}
print"\n";
?>
