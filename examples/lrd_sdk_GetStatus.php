<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

/*Check if the segment of MAC address has any leading zero since printing an integer
with leading zero does not print the zero. e.g: '0e' will be printed as 'e',
so this function converts integer to string and adds a leading zero if it finds one.*/
function checkLeadingZero($mac, $len){
	for($x = 0; $x <= MAC_ADDR_SZ - 1; $x++){
		if($mac[$x] < dechex(16)){
			$macChar[$x] = strval(0) . strval($mac[$x]);
		}else{
			$macChar[$x]= strval($mac[$x]);
		}
	}
	$MAC = implode(':', $macChar);
	return $MAC;
}

$status = new CF10G_STATUS();
$rval = GetCurrentStatus( $status );

$profileName = str_repeat(" ",CONFIG_NAME_SZ);

if($rval == SDCERR_SUCCESS){
	$ssid = new LRD_WF_SSID();
	LRD_WF_GetSSID($ssid);
	if ($ssid->len){
		for ($x = 0; $x <= ($ssid->len); $x++){
			$ssidVal[$x]= chr(uchar_array_getitem($ssid->val,$x));
		}
		$ssidValFinal = implode('', $ssidVal);
	}
	if($status->cardState == CARDSTATE_AP_MODE){
		print "AP Mode not implemented\n";
		exit();
	}
	if(GetCurrentConfig(NULL, $profileName)==SDCERR_SUCCESS){
		$cconfig = new SDCConfig();
		if (GetConfig($profileName, $cconfig)==SDCERR_SUCCESS){
			if ($cconfig->radioMode == RADIOMODE_ADHOC) {

				for ($x = 0; $x <= MAC_ADDR_SZ - 1; $x++){
					$macAddress[$x]=dechex(uchar_array_getitem($status->client_MAC,$x));
				}
				$MAC = checkLeadingZero($macAddress, MAC_ADDR_SZ);

				for ($x = 0; $x <= IPv4_ADDR_SZ - 1; $x++){
					$ipAddressClient[$x]=uchar_array_getitem($status->client_IP,$x);
				}

				print "Status: Adhoc\n";
				print "Profile name: $status->configName\n";
				print "SSID: $ssidValFinal\n";
				print "Channel: $status->channel\n";
				print "MAC: $MAC\n";

				print "IP: ";
				if($ipAddressClient[0] != 0){
					$IP = implode('.', $ipAddressClient);
					print $IP;
				}
				print "\n";

				print"Tx Power: $status->txPower"." mW\n";
				exit();
			}
		}
	}

	for ($x = 0; $x <= MAC_ADDR_SZ - 1; $x++){
		$macAddress[$x]=dechex(uchar_array_getitem($status->client_MAC,$x));
	}
	$MAC = checkLeadingZero($macAddress, MAC_ADDR_SZ);

	for ($x = 0; $x <= IPv4_ADDR_SZ - 1; $x++){
		$ipAddress[$x]=uchar_array_getitem($status->client_IP,$x);
	}

	for ($x = 0; $x <= MAC_ADDR_SZ - 1; $x++){
		$APmacAddress[$x]=dechex(uchar_array_getitem($status->AP_MAC,$x));
	}
	$APMAC = checkLeadingZero($APmacAddress, MAC_ADDR_SZ);

	for ($x = 0; $x <= IPv4_ADDR_SZ - 1; $x++){
		$APipAddress[$x]=uchar_array_getitem($status->AP_IP,$x);
	}
	$APIP = implode('.', $APipAddress);

	$bitRate = $status->bitRate/2;

	print "Status: ";
	switch($status->cardState){
		case CARDSTATE_NOT_INSERTED:
			print "Card not inserted\n";
			break;
		case CARDSTATE_NOT_ASSOCIATED:
			print "Not Associated\n";
			break;
		case CARDSTATE_ASSOCIATED:
			print "Associated\n";
			break;
		case CARDSTATE_AUTHENTICATED:
			print "Authenticated\n";
			break;
		case CARDSTATE_FCCTEST:
			print "FCC Test\n";
			break;
		case CARDSTATE_NOT_SDC:
			print "Not SDC\n";
			break;
		case CARDSTATE_DISABLED:
			print "Disabled\n";
			break;
		case CARDSTATE_ERROR:
			print "Error\n";
			break;
		case CARDSTATE_AP_MODE:
			print "AP Mode\n";
			break;
	}

	print "Profile Name: $status->configName\n";

	print "SSID: ";
	if (($ssid->len) || (($status->cardState == CARDSTATE_ASSOCIATED) ||
		    ($status->cardState == CARDSTATE_AUTHENTICATED))){
		print $ssidValFinal;
	}
	print "\n";

	print "channel: $status->channel\n";
	print "RSSI: $status->rssi\n";
	print "Device Name: $status->clientName\n";

	print "MAC: $MAC\n";

	print "IP: ";
	if($ipAddress[0] != 0){
		$IP = implode('.', $ipAddress);
		print $IP;
	}
	print "\n";

	$result = new_SDCERRp();
	$numElements = new_size_tp();
	$numEntries = 5;
	size_tp_assign($numElements,$numEntries);
	$list = lrd_php_sdk::new_LRD_WF_PHP_GetIpV6Address($numElements,$result);
	if (SDCERRp_value($result) == SDCERR_INSUFFICIENT_MEMORY){ //  make one more try
		lrd_php_sdk::delete_LRD_WF_PHP_GetIpV6Address($list);
		$numEntries += 5;
		size_tp_assign($numElements,$numEntries);
		$list = lrd_php_sdk::new_LRD_WF_PHP_GetIpV6Address($numElements,$result);
	}
	if (SDCERRp_value($result) == SDCERR_SUCCESS){
		for($h = 0; $h < size_tp_value($numElements); $h++){
			unset($item);
			unset($ipv6Address);
			$item = lrd_php_sdk::LRD_WF_PHP_GetIpV6Address_get($list,$h);
			echo "IPv6" . ": " . $item . "\n";
		}
	}

	lrd_php_sdk::delete_LRD_WF_PHP_GetIpV6Address($list);
	delete_size_tp($numElements);
	delete_SDCERRp($result);

	print "AP Name: $status->APName\n";
	print "AP MAC: $APMAC\n";
	print "AP IP: $APIP\n";
	print "Bit Rate: $bitRate"." Mbps\n";
	print "Tx Power: $status->txPower"." mW\n";
	print "Beacon Period: $status->beaconPeriod"." ms\n";
	print "DTIM: $status->DTIM\n";

} else{
	print "Failed to receive status\n";
}

?>
