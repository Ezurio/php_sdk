<?php

if(!extension_loaded('lrd_php_sdk')){
	print "ERROR: failed to load lrd_php_sdk\n";
}

$property = "wmm";
$value = "0";

function onOffEnableDisable($input)
{
	if (($input=="1") || ($input=="on") ||
	    ($input=="enable") || ($input=="enabled"))
		return 1;
	if (($input=="0") || ($input=="off") ||
	    ($input=="disable") || ($input=="disabled"))
		return 0;
	return -1;
}

function setAChannelSet($cfg, $value)
{
	$result = SDCERR_SUCCESS;
	$usage = "usage: global set a-channel-set <<0|none>|<all|full>|<comma-delimited list of a-band channels>>";
	if (($value == "full") || ($value == "all"))
		$cfg->aLRS = 0x00ffffff;
	else if ($value == "none" | $value == "0") {
		if ($cfg->bLRS == 0) {
			$result = SDCERR_INVALID_PARAMETER;
		} else
			$cfg->aLRS = 0;
	} else {
		$bitMask = new_ulongp();
		$channels = new LRD_WF_LRSChannels();
		$ch_array = explode(",", $value);
		$size = count($ch_array);
		for($i = 0; $i < $size; $i++){
			ulong_array_setitem($channels->chan, $i, $ch_array[$i]);
		}
		$result = LRD_WF_GetaLRSBitmask($size, $channels, $bitMask);
		if($result != SDCERR_SUCCESS){
			print"\nSet bitmask failed, $usage";
		}
		$cfg->aLRS = ulongp_value($bitMask);
		delete_ulongp($bitMask);
	}
	return $result;
}

function setAuthServerType($cfg, $value)
{
	$usage = "usage: global set auth-server-type <<1>|<2>>";
	if (($value == "1") || ($value == "acs"))
		$cfg->authServerType = 0;
	else if (($value == "2") || ($value == "sbr"))
		$cfg->authServerType = 1;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setAutoProfile($cfg, $value)
{
	$usage = "usage: global set auto-profile <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==1)
		$cfg->autoProfile |= 1;
	else if ($arg1==0)
		$cfg->autoProfile &= ~1;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setBGChannelSet($cfg, $value)
{
	$result = SDCERR_SUCCESS;
	$usage = "usage: global set bg-channel-set <<0|none>|<all|full>|<comma-delimited list of bg-band channels>>";
	if(($value == "full") || ($value == "all"))
		$cfg->bLRS = 0x0000ffff;
	else if($value == "none" | $value == "0") {
		if ($cfg->aLRS == 0) {
			$result = SDCERR_INVALID_PARAMETER;
		} else
			$cfg->bLRS = 0;
	} else {
		$bitMask = new_ulongp();
		$channels = new LRD_WF_LRSChannels();
		$ch_array = explode(",", $value);
		$size = count($ch_array);
		for($i = 0; $i < $size; $i++){
			ulong_array_setitem($channels->chan, $i, $ch_array[$i]);
		}
		$result = LRD_WF_GetbLRSBitmask($size, $channels, $bitMask);
		if($result != SDCERR_SUCCESS) {
			print"\nSet bitmask failed, $usage";
		}
		$cfg->bLRS = ulongp_value($bitMask);
		delete_ulongp($bitMask);
	}
	return $result;
}

function setBeaconMissTime($cfg, $value)
{
	$usage = "usage: global set beacon-miss-time not in MIN-MAX range";
	if(($value >= BEACONMISSTIME_LOW) && ($value <= BEACONMISSTIME_HIGH))
		$cfg->BeaconMissTimeout = $value;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setBTCoexist($cfg, $value)
{
	$usage = "usage: global set bt-coexist <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==1)
		$cfg->BTcoexist = BT_ON;
	else if ($arg1==0)
		$cfg->BTcoexist = BT_OFF;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setCCX($cfg, $value)
{
	$usage = "usage: global set ccx-features <<2|off>|<1|full>|<0|optimized>>";
	if (($value == "2") || ($value == "off"))
		$cfg->CCXfeatures = CCX_OFF;
	else if (($value == "1") || ($value == "full" ) || ($value == "on" ))
		$cfg->CCXfeatures = CCX_FULL;
	else if (($value == "0") || ($value == "optimized" ))
		$cfg->CCXfeatures = CCX_OPTIMIZED;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setCertStore($cfg, $value)
{
	$cfg->certPath = $value;
	return SDCERR_SUCCESS;
}

function setDateCheck($cfg, $value)
{
	$usage = "usage: global set date-check <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==1)
		$cfg->suppInfo |= SUPPINFO_TLS_TIME_CHECK;
	else if ($arg1==0)
		$cfg->suppInfo &= ~SUPPINFO_TLS_TIME_CHECK;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setDefAdhocChannel($cfg, $value)
{
	$usage = "usage: global set def-adhoc-channel <valid Ad Hoc channel>";
	if (($value >= 1) && ($value <= 14) || ($value == 36) || ($value == 40) || ($value == 44) || ($value == 48))
		$cfg->defAdhocChannel = $value;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setDFSChannels($cfg, $value)
{
	$usage = "usage: global set dfs-channels <<0|off>|<1|full>|<2|optimized>>";
	$arg1 = onOffEnableDisable($value);
	if (($arg1==0) || ($value == "off"))
		$cfg->DFSchannels = 0;
	else if (($arg1==1) || ($value == "full") || ($value == "on"))
		$cfg->DFSchannels = 1;
	else if (($value == "2") || ($value == "optimized"))
		$cfg->DFSchannels = 2;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setFipsMode($cfg, $value)
{
	$usage = "usage: global set fips <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	$current = str_repeat(" ",1);
	$current = -1;
	if(LRD_WF_GetFipsStatus($current, NULL)!=SDCERR_SUCCESS)
		$current = -1;
	switch ($arg1){
		case 1:
			$cfg->suppInfo |= 1;
			if ($current != 1 ) // wasn't already enabled
				print "\nWireless restart required to activate fips mode";
			break;
		case 0:
			$cfg->suppInfo &= ~1;
			if ($current != 0 ) // wasn't already disabled
				print "\nWireless restart required to deactivate fips mode";
			break;
		default:
			print $usage;
			return SDCERR_INVALID_PARAMETER;
	}
	return SDCERR_SUCCESS;
}

function setIgnoreNullSsid2($cfg, $value)
{
	$usage = "usage: global set ignore-null-ssid <<0|disable>|<1|enable>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==0)
		setIgnoreNullSsid(0);
	else if ($arg1==1)
		setIgnoreNullSsid(1);
	else{
		print "$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setPMKCaching($cfg, $value)
{
	$usage = "usage: global set pmk-caching <<0|standard>|<1|opmk>>";
	$arg1 = onOffEnableDisable($value);
	if (($arg1==1) || ($value=="opmk"))
		$cfg->PMKcaching = 1;
	else if (($arg1==0) || ($value=="standard"))
		$cfg->PMKcaching = 0;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setProbeDelay($cfg, $value)
{
	$usage = "usage: global set probe-delay should be in Min-Max range";
	if(($value >= PROBE_DELAY_LOW) && ($value <= PROBE_DELAY_HIGH))
		$cfg->probeDelay = $value;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setRoamPeriodms($cfg, $value)
{
	$usage = "usage: global set roam-period-ms should be in Min-Max range";
	if (($value >= ROAM_PERIOD_MS_LOW) && ($value <= ROAM_PERIOD_MS_HIGH))
		$cfg->roamPeriodms = $value;
	else{
		print "\nusage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setRoamTrigger($cfg, $value)
{
	$usage = "usage: global set roam-trigger <50|55|60|65|70|75|80|85|90>";
	if (($value >= ROAM_TRIGGER_LOW) && ($value <= ROAM_TRIGGER_HIGH))
		$cfg->roamTrigger = $value;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setRTSThresh($cfg, $value)
{
	$usage = "usage: global set rts should be in between Min-Max value";
	if (($value > RTS_LOW) && ($value <= RTS_HIGH))
		$cfg->RTSThreshold = $value;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setScanDFSTime($cfg, $value)
{
	$usage = "usage: global set scan-dfs-time should lie in Min-Max range";
	if (($value >= SCANDFSTIME_LOW) && ($value <= SCANDFSTIME_HIGH))
		$cfg->scanDFSTime = $value;
	else{
		print"\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setTTLSInnerMethod($cfg, $value)
{
	$usage = "usage: global set ttls-inner-method <auto|mschapv2|mschap|pap|chap|eap_mschapv2>";
	if (($value=="0") || ($value=="auto") || ($value=="ttls_auto"))
		$cfg->TTLSInnerMethod = TTLS_AUTO;
	else if (($value=="1") || ($value=="mschapv2") || ($value=="ttls_mschapv2"))
		$cfg->TTLSInnerMethod = TTLS_MSCHAPV2;
	else if (($value=="2") || ($value=="mschap") || ($value=="ttls_mschap"))
		$cfg->TTLSInnerMethod = TTLS_MSCHAP;
	else if (($value=="3") || ($value=="pap") || ($value=="ttls_pap"))
		$cfg->TTLSInnerMethod = TTLS_PAP;
	else if (($value=="4") || ($value=="chap") || ($value=="ttls_chap"))
		$cfg->TTLSInnerMethod = TTLS_CHAP;
	else if (($value=="5") || ($value=="eap_mschapv2") || ($value=="ttls_eap_mschapv2"))
		$cfg->TTLSInnerMethod = TTLS_EAP_MSCHAPV2;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setUAPSD($cfg, $value)
{
	$usage = "usage: global set uapsd <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==1)
		$cfg->uAPSD = UAPSD_AC_VO | UAPSD_AC_VI | UAPSD_AC_BK | UAPSD_AC_BE;
	else if ($arg1==0)
		$cfg->uAPSD = 0;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

function setWMM($cfg, $value)
{
	$usage = "usage: global set wmm <<0|off>|<1|on>>";
	$arg1 = onOffEnableDisable($value);
	if ($arg1==1)
		$cfg->WMEenabled = 1;
	else if ($arg1==0)
		$cfg->WMEenabled = 0;
	else{
		print "\n$usage";
		return SDCERR_INVALID_VALUE;
	}
	return SDCERR_SUCCESS;
}

$cfg = new SDCGlobalConfig();
$rcs = new_RADIOCHIPSETp();
$supportedGlobals = new SDCGlobalConfig();

$result = LRD_WF_GetRadioChipSet($rcs);
if($result != SDCERR_SUCCESS){
	print "\nGet Radio Chip failed";
	exit();
}

$result = GetGlobalSettings($cfg);
if($result != SDCERR_SUCCESS){
	print "\nGet Global Setting failed";
	exit();
}

$result = LRD_WF_GetSupportedGlobals($rcs, $supportedGlobals);
delete_RADIOCHIPSETp($rcs);

if($result != SDCERR_SUCCESS){
	print "\nGet Supported Global failed";
	exit();
}

$result = SDCERR_FAIL;
if($property == "a-channel-set"){
	$result = setAChannelSet($cfg, $value);
}else if($property == "auth-server-type"){
	$result = setAuthServerType($cfg, $value);
}else if($property == "auto-profile"){
	$result = setAutoProfile($cfg, $value);
}else if($property == "bg-channel-set"){
	$result = setBGChannelSet($cfg, $value);
}else if($property == "beacon-miss-time"){
	$result = setBeaconMissTime($cfg, $value);
}else if($property == "bt-coexist"){
	$result = setBTCoexist($cfg, $value);
}else if($property == "ccx-features"){
	$result = setCCX($cfg, $value);
}else if($property == "certpath"){
	$result = setCertStore($cfg, $value);
}else if($property == "date-check"){
	$result = setDateCheck($cfg, $value);
}else if($property == "def-adhoc-channel"){
	$result = setDefAdhocChannel($cfg, $value);
}else if($property == "dfs-channels"){
	$result = setDFSChannels($cfg, $value);
}else if($property == "fips"){
	$result = setFipsMode($cfg, $value);
}else if($property == "ignore-null-ssid"){
	$result = setIgnoreNullSsid2($cfg, $value);
}else if($property == "pmk-caching"){
	$result = setPMKCaching($cfg, $value);
}else if($property == "probe-delay"){
	$result = setProbeDelay($cfg, $value);
}else if($property == "roam-period-ms"){
	$result = setRoamPeriodms($cfg, $value);
}else if($property == "roam-trigger"){
	$result = setRoamTrigger($cfg, $value);
}else if($property == "rts"){
	$result = setRTSThresh($cfg, $value);
}else if($property == "scan-dfs-time"){
	$result = setScanDFSTime($cfg, $value);
}else if($property == "ttls-inner-method"){
	$result = setTTLSInnerMethod($cfg, $value);
}else if($property == "uapsd"){
	$result = setUAPSD($cfg, $value);
}else if($property == "wmm"){
	$result = setWMM($cfg, $value);
}else{
	print"\nInvalid property";
	exit();
}
if($result == SDCERR_SUCCESS){
	$result = SetGlobalSettings($cfg);
	if($result != SDCERR_SUCCESS)
		print"\nSet Global Setting Failed, err: $result";
} else{
	print"\nFunction $property failed";
}

?>
