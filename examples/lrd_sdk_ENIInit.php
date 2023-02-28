<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}
$result = LRD_ENI_Init();

if($result == SDCERR_SUCCESS){
	print"\nENI file initialization successful";
} else{
	print"\nENI file initialization failed";
}
print"\n";
?>
