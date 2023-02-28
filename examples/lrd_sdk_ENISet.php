<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

function SetProperty($property, $interface, $value){
	$property = strtolower($property);
	$strOn = "on";

	if ( $property == LRD_ENI_PROPERTY_STATE){
		$value = strtolower($value);
		if( $value == "on"){
			$result = LRD_ENI_EnableInterface($interface);
		} else {
			$result = LRD_ENI_DisableInterface($interface);
		}
	} else if ( $property == LRD_ENI_PROPERTY_ADDRESS ){
		$result = LRD_ENI_SetAddress($interface,$value);
	} else if ( $property ==LRD_ENI_PROPERTY_NETMASK) {
		$result = LRD_ENI_SetNetmask($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_NAMESERVER) {
		$result = LRD_ENI_SetNameserver($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_GATEWAY) {
		$result = LRD_ENI_SetGateway($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_BROADCAST){
		$result = LRD_ENI_SetBroadcastAddress($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_AUTO) {
		$value = strtolower($value);
		if ( $value == "on"){
			$result = LRD_ENI_AutoStartOn($interface);
		} else {
			$result = LRD_ENI_AutoStartOff($interface);
		}
	} else if ( $property == LRD_ENI_PROPERTY_METHOD) {
		$value = strtolower($value);
		$result = LRD_ENI_SetMethod($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_BRIDGEPORTS){
		$result = LRD_ENI_SetBridgePorts($interface,$value);
	} else if ( $property == LRD_ENI_PROPERTY_HOSTAPD) {
		$value = strtolower($value);
		if($value == "on"){
			$result = LRD_ENI_EnableHostAPD($interface);
		} else {
			$result = LRD_ENI_DisableHostAPD($interface);
		}
	} else {
		$result = SDCERR_FAIL;
	}
	return $result;
}

if(file_exists('/etc/network/interfaces')){
	$property  = "Method";
	$value = "static";
	$interface = "eth99";
	$result = SetProperty($property, $interface, $value);
	if($result == SDCERR_SUCCESS)
		print"\nENI file updated successfully";
	else
		print"\nFailed to update ENI file";
} else{
	print"\nENI File does not exist";
}
print"\n";
?>
