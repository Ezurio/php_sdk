<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}


if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";
	$method = "static";
	$address = "2001:db8::1";
	$netmask = "64";
	$gateway = "2001:db8::2";
	$nameserver = "2001:db8::10";
	$dhcp = "stateless";

	$result = LRD_ENI_AddInterface($interface);
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to add $interface";
	} else {
		$result = LRD_ENI_AddInterface6($interface);
		if ($result != SDCERR_SUCCESS) {
			print "\nFailed to add IPv6 on $interface";
		} else {
			$result = LRD_ENI_SetMethod6($interface,$method);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 method on $interface";
			} else {
				print "\nFailed to set IPv6 method on $interface";
			}

			$result = LRD_ENI_SetAddress6($interface,$address);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 address on $interface";
			} else {
				print "\nFailed to set IPv6 address on $interface";
			}

			$result = LRD_ENI_SetNetmask6($interface,$netmask);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 netmask on $interface";
			} else {
				print "\nFailed to set IPv6 netmask on $interface";
			}

			$result = LRD_ENI_SetGateway6($interface,$gateway);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 gateway on $interface";
			} else {
				print "\nFailed to set IPv6 gateway on $interface";
			}

			$result = LRD_ENI_SetNameserver6($interface,$nameserver);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 nameserver on $interface";
			} else {
				print "\nFailed to set IPv6 nameserver on $interface";
			}

			$result = LRD_ENI_SetDhcp6($interface,$dhcp);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 DCHP on $interface";
			} else {
				print "\nFailed to set IPv6 DCHP on $interface";
			}

			$result = LRD_ENI_DisableInterface6($interface);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully disabled IPv6 on $interface";
			} else {
				print "\nFailed to disable IPv6 on $interface";
			}

			$result = LRD_ENI_EnableInterface6($interface);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully enabled IPv6 on $interface";
			} else {
				print "\nFailed to enable IPv6 on $interface";
			}

			$result = LRD_ENI_ClearProperty6($interface,LRD_ENI_PROPERTY_ADDRESS);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 address on $interface";
			} else {
				print "\nFailed to set IPv6 address on $interface";
			}

			$result = LRD_ENI_ClearProperty6($interface,LRD_ENI_PROPERTY_NETMASK);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 netmask on $interface";
			} else {
				print "\nFailed to set IPv6 netmask on $interface";
			}

			$result = LRD_ENI_ClearProperty6($interface,LRD_ENI_PROPERTY_GATEWAY);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 gateway on $interface";
			} else {
				print "\nFailed to set IPv6 gateway on $interface";
			}

			$result = LRD_ENI_ClearProperty6($interface,LRD_ENI_PROPERTY_NAMESERVER);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 nameserver on $interface";
			} else {
				print "\nFailed to set IPv6 nameserver on $interface";
			}

			$result = LRD_ENI_ClearProperty6($interface,LRD_ENI_PROPERTY_DHCP);
			if ($result == SDCERR_SUCCESS) {
				print "\nSuccessfully set IPv6 DHCP on $interface";
			} else {
				print "\nFailed to set IPv6 DHCP on $interface";
			}

			$result = LRD_ENI_RemoveInterface6($interface);
			if ($result != SDCERR_SUCCESS) {
				print "\nFailed to remove IPv6 on $interface";
			}
		}

		$result = LRD_ENI_RemoveInterface6($interface);
	}
	if ($result != SDCERR_SUCCESS) {
		print "\nFailed to remove IPv6 on $interface";
	}

} else{
	print"\nENI File does not exist";
}
print"\n";
?>
