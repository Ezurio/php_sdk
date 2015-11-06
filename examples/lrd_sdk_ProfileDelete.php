<?php

include("../lrd_php_sdk.php");
if(!extension_loaded('lrd_php_sdk')){
        print "ERROR: failed to load lrd_php_sdk\n";
}

$profileName = "example";

$result = DeleteConfig($profileName);
if ($result == SDCERR_SUCCESS){
	print "Profile " . $profileName . " deleted\n";
}
else{
	if ($result == SDCERR_INVALID_NAME){
		print "Profile not found\n";
	}
	else if ($result == SDCERR_INVALID_DELETE){
		print "Cannot delete the active profile\n";
	}
}

?>