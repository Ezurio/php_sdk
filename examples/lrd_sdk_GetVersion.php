<?php

if(!extension_loaded('lrd_php_sdk')){
	print "ERROR: failed to load lrd_php_sdk\n";
}

$SDKBuild = new_ulongp();
$result = GetSDKBuild($SDKBuild);
$SDKBuildValue = ulongp_value($SDKBuild);
if($result == SDCERR_SUCCESS){
	print "SDK: ";
	print (($SDKBuildValue & 0xff000000) >> 24);
	print "." . (($SDKBuildValue & 0xff0000) >> 16);
	print "." . (($SDKBuildValue & 0xff00) >> 8);
	print "." . ($SDKBuildValue & 0xff);

	$SDKVersion = new_ulongp();
	$result = GetSDKVersion($SDKVersion);
	if($result == SDCERR_SUCCESS){
		$SDKVersionValue = ulongp_value($SDKVersion);
		print "-";
		print (($SDKVersionValue & 0xff000000) >> 24);
		print "." . (($SDKVersionValue & 0xff0000) >> 16);
		print "." . (($SDKVersionValue & 0xff00) >> 8);
		print "." . ($SDKVersionValue & 0xff);
	}
	print "\n";
	delete_ulongp($SDKVersion);
}
delete_ulongp($SDKBuild);

print "PHP_SDK version: " . LRD_PHP_SDK_BUILD_MAJOR . "." . LRD_PHP_SDK_BUILD_MINOR . "." . LRD_PHP_SDK_BUILD_REVISION . "." . LRD_PHP_SDK_BUILD_SUB_REVISION;
print "-" .LRD_PHP_SDK_VERSION_MAJOR . "." . LRD_PHP_SDK_VERSION_MINOR . "." . LRD_PHP_SDK_VERSION_REVISION . "." . LRD_PHP_VERSION_SUB_REVISION . "\n";

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

$firmwareStringLength = new_intp();
intp_assign($firmwareStringLength,80);
$firmwareString = str_repeat(" ",intp_value($firmwareStringLength));
$firmwareSDCERR = LRD_WF_GetFirmwareVersionString($firmwareString, $firmwareStringLength);
if ($firmwareSDCERR == SDCERR_SUCCESS){
	print "Firmware: " . $firmwareString . "\n";
}else{
	print "Firmware not loaded.  Unable to check firmware version.\n";
}
delete_intp($firmwareStringLength);

$SDCSupp = system('sdcsupp -v', $result);
if($result == SDCERR_SUCCESS){
	print $SDCSupp;
}

if(file_exists('/etc/laird-release') | file_exists('/etc/summit-release')){
	$BuildString = file_get_contents('/etc/laird-release');
	if($BuildString == false){
		$BuildString = file_get_contents('/etc/summit-release');
	}
	if($BuildString != false){
		print $BuildString;
	}
}
?>

