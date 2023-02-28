<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";

	$result = LRD_ENI_RemoveInterface6($interface);
	if ($result == SDCERR_SUCCESS) {
		$result = LRD_ENI_RemoveInterface($interface);
	}

	if ($result == SDCERR_SUCCESS) {
		print "\nIPv6 on $interface has been removed successfully";
	} else{
		print "\nFailed to remove IPv6 from interface $interface";
	}
} else{
	print"\nENI File does not exist";
}
print"\n";
?>
