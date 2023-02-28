<?php

if(!extension_loaded('lrd_php_sdk')){
        print "ERROR: failed to load lrd_php_sdk\n";
}

$profileName = "example";
$cfgs = new SDCConfig();

$result = CreateConfig($cfgs);
if ($result == SDCERR_SUCCESS){
	$cfgs->configName = $profileName;
	$result = AddConfig($cfgs);
	if ($result == SDCERR_SUCCESS){
		print "Profile " . $cfgs->configName .  " added\n";
	}else{
		print "Failed to add config\n";
	}
}
else{
	print "Failed to create config\n";
}

free_SDCConfig($cfgs);
?>