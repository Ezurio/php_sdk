<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

const BUFSIZE = 100;

if(file_exists('/etc/network/interfaces')){
	$interface = "eth99";
	$autoStart = new_intp();
	$hostapd = new_intp();
	$nat = new_intp();
	$method = str_repeat(" ",BUFSIZE);
	$value = str_repeat(" ",BUFSIZE);

	$result = LRD_ENI_GetAutoStart($interface,$autoStart);
	if ($result == SDCERR_SUCCESS){
		if (intp_value($autoStart))
			print "Auto start is enabled\n";

		print "IPv4\n";
		$result = LRD_ENI_GetMethod($interface,$method,BUFSIZE);
		if ($result == SDCERR_SUCCESS){
			print "\t" . LRD_ENI_PROPERTY_METHOD . " is $method\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_ADDRESS, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_ADDRESS . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_NETMASK, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_NETMASK . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_GATEWAY, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_GATEWAY . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_BROADCAST, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_BROADCAST . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_NAMESERVER, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_NAMESERVER . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_BRIDGEPORTS, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_BRIDGEPORTS . " $value\n";

			$result = LRD_ENI_GetHostAPD($interface, $hostapd);
			if ($result == SDCERR_SUCCESS){
				if (intp_value($hostapd)){
					if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_POSTCFG, $value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_POSTCFG . " $value\n";

					if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_PRECFG, $value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_PRECFG . " $value\n";

					if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_HOSTAPD, $value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_HOSTAPD . " $value\n";
				}
			}

			$result = LRD_ENI_GetNat($interface, $nat);
			if ($result == SDCERR_SUCCESS){
				if (intp_value($nat)){
					if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_POSTCFG, value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_POSTCFG . " $value\n";

					if (LRD_ENI_GetInterfacePropertyValue($interface, LRD_ENI_PROPERTY_PRECFG, value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_PRECFG . " $value\n";
				}
			}
		}

		$result = LRD_ENI_GetMethod6($interface,$method,BUFSIZE);
		if ($result == SDCERR_SUCCESS){
			print "IPv6\n";
			print "\t" . LRD_ENI_PROPERTY_METHOD . " is $method\n";

			if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_ADDRESS, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_ADDRESS . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_NETMASK, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_NETMASK . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_GATEWAY, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_GATEWAY . " $value\n";

			if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_NAMESERVER, $value, BUFSIZE) == SDCERR_SUCCESS)
				print "\t" . LRD_ENI_PROPERTY_NAMESERVER . " $value\n";

			$result = LRD_ENI_GetNat6($interface, $nat);
			if ($result == SDCERR_SUCCESS){
				if (intp_value($nat)){
					if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_POSTCFG6, value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_POSTCFG . " $value\n";

					if (LRD_ENI_GetInterfacePropertyValue6($interface, LRD_ENI_PROPERTY_PRECFG6, value, BUFSIZE) == SDCERR_SUCCESS)
						print "\t" . LRD_ENI_PROPERTY_PRECFG6 . " $value\n";
				}
			}
		}
	}

	delete_intp($autoStart);
	delete_intp($hostapd);
	delete_intp($nat);

} else{
	print"\nENI File does not exist";
}
print"\n";
?>