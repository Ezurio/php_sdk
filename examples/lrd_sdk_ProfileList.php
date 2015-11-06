<?php

require("../lrd_php_sdk.php");
if(!extension_loaded('lrd_php_sdk')){
        print "ERROR: failed to load lrd_php_sdk\n";
}

$Count = new_ulongp();
$currentConfig = str_repeat(" ",CONFIG_NAME_SZ);
$result = GetNumConfigs($Count);
if($result == SDCERR_SUCCESS){
	$cfgs = new_SDCConfig_array(ulongp_value($Count));
	$result = GetAllConfigs($cfgs, $Count);
	if($result == SDCERR_SUCCESS){
		$result = GetCurrentConfig(NULL, $currentConfig);
		for($i = 0;$i < ulongp_value($Count);$i++) {
			$singleCFG = lrd_php_sdk::SDCConfig_array_getitem($cfgs,$i);
			print $singleCFG->configName;
			if($result == SDCERR_SUCCESS && trim($currentConfig) == $singleCFG->configName){
				print " ACTIVE";
			}
			print "\n";
		}
	}
	delete_SDCConfig_array($cfgs);
}
delete_ulongp($Count);
?>