<?php

include("../lrd_php_sdk.php");
if(!extension_loaded('lrd_php_sdk')){
	print "ERROR: failed to load lrd_php_sdk\n";
}

$SDKVersion = new_ulongp();
$result = GetSDKVersion($SDKVersion);
$SDKVersionValue = ulongp_value($SDKVersion);
if($result == SDCERR_SUCCESS){
	print "SDK: ";
	print (($SDKVersionValue & 0xff000000) >> 24);
	print "." . (($SDKVersionValue & 0xff0000) >> 16);
	print "." . (($SDKVersionValue & 0xff00) >> 8);
	print "." . ($SDKVersionValue & 0xff);
	print "\n";
}
delete_ulongp($SDKVersion);

print "PHP_SDK version: " . LRD_PHP_SDK_VERSION_MAJOR . "." . LRD_PHP_SDK_VERSION_MINOR . "." . LRD_PHP_SDK_VERSION_REVISION . "." . LRD_PHP_VERSION_SUB_REVISION . "\n";

$rcs = new_RADIOCHIPSETp();
$result = LRD_WF_GetRadioChipSet($rcs);
if($result == SDCERR_SUCCESS){
	print "Hardware Chipset: ";
	switch (RADIOCHIPSETp_value($rcs)) {
		case RADIOCHIPSET_SDC10:
			print "10 ";
			break;
		case RADIOCHIPSET_SDC15:
			print "15 ";
			break;
		case RADIOCHIPSET_SDC30:
			print "30 ";
			break;
		case RADIOCHIPSET_SDC40L:
			print "40L ";
			break;
		case RADIOCHIPSET_SDC40NBT:
			print "40NBT ";
			break;
		case RADIOCHIPSET_SDC45:
			print "45 ";
			break;
		case RADIOCHIPSET_SDC50:
			print "50 ";
			break;
		default:
			print "No Hardware Detected";
	}
	print "\n";
}
delete_RADIOCHIPSETp($rcs);

$status = new CF10G_STATUS();
$result = GetCurrentStatus($status);
if($result == SDCERR_SUCCESS){
	$DriverVersion = $status->driverVersion;
	print "Driver version: ";
	if ($DriverVersion & 0xff000000)
	{
		print (($DriverVersion & 0xff000000) >> 24);
		print "." . (($DriverVersion & 0xff0000) >> 16);
		print "." . (($DriverVersion & 0xff00) >> 8);
		print "." . ($DriverVersion & 0xff);
	}
	else
	{
		print "." . (($DriverVersion & 0xff0000) >> 16);
		print "." . (($DriverVersion & 0xff00) >> 8);
		print "." . ($DriverVersion & 0xff);
	}
	print "\n";
}
else{
	print "Driver not loaded.  Unable to check driver version.\n";
}
$SDCSupp = system('sdcsupp -v', $result);
if($result == SDCERR_SUCCESS){
	print $SDCSupp;
}

if(file_exists('/etc/summit-release')){
	$BuildString = file_get_contents('/etc/summit-release');
	if($BuildString != false){
		print $BuildString;
	}
}
?>

