<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";
	$result = LRD_ENI_AddInterface($interface);

	if ($result == SDCERR_SUCCESS) {
		print "\nInterface: $interface has been added successfully";
	} else{
		print "\nFailed to add interface $interface";
	}
} else{
	print"\nENI File does not exist";
}
print"\n";
?>
