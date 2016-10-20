<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";

	$result = LRD_ENI_AddInterface($interface);
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to add $interface";
	}

	$result = LRD_ENI_AddInterface6($interface);
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to add IPv6 on $interface";
	}

	$result = LRD_ENI_EnableNat6($interface);
	if ($result == SDCERR_SUCCESS) {
		print "Successfully enabled NAT\n";

		$result = LRD_ENI_DisableNat6($interface);

		if ($result == SDCERR_SUCCESS) {
			print "Successfully disabled NAT\n";
		} else {
			print "Failed to disable NAT\n";
		}
	} else {
		print "Failed to enable NAT\n";
	}

	$result = LRD_ENI_RemoveInterface6($interface);
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to remove IPv6 on $interface";
	}

	$result = LRD_ENI_RemoveInterface($interface);
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to remove $interface";
	}

} else{
	print"\nENI File does not exist";
}
print"\n";
?>
