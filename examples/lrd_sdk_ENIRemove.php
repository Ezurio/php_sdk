<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";
	$result = LRD_ENI_RemoveInterface($interface);

	if ($result == SDCERR_SUCCESS) {
		print "\nInterface: $interface has been removed successfully";
	} else{
		print "\nFailed to remove interface $interface";
	}
} else{
	print"\nENI File does not exist";
}
print"\n";
?>
