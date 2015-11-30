<?php

include("../lrd_php_sdk.php");
if(!extension_loaded('lrd_php_sdk')){
	print "ERROR: failed to load lrd_php_sdk\n";
}

$rcs = new_RADIOCHIPSETp();
$result = LRD_WF_GetRadioChipSet($rcs);
if($result == SDCERR_SUCCESS){
	$supportedGlobals = new SDCGlobalConfig();
	$result = LRD_WF_GetSupportedGlobals(RADIOCHIPSETp_value($rcs), $supportedGlobals);
	if($result == SDCERR_SUCCESS){
		$cfgs = new SDCGlobalConfig();
		$result = GetGlobalSettings($cfgs);
		if($result == SDCERR_SUCCESS){
			if ($supportedGlobals->aLRS){
				print "A Channel Set: ";
				if (dechex($cfgs->aLRS) == "ffffff"){
					print "Full";
				}
				else if (dechex($cfgs->aLRS) == "0"){
					print "None";
				}
				else {
					$numChannels = new_ulongp();
					$channels = new LRD_WF_LRSChannels();
					$result = LRD_WF_GetaLRSChannels($numChannels, $channels, $cfgs->aLRS);
					if($result == SDCERR_SUCCESS){
						for($c = 0; $c < ulongp_value($numChannels); $c++) {
							print ulong_array_getitem($channels->chan,$c);
							if($c < (ulongp_value($numChannels) - 1)){
								print ",";
							}
						}
					}
					delete_ulongp($numChannels);
				}
				print "\n";
			}

			if ($supportedGlobals->aggScanTimer){
				print "Aggressive Scan: " . $cfgs->aggScanTimer;
				print "\n";
			}

			if ($supportedGlobals->authServerType){
				print "Auth Server Type: Type " . ($cfgs->authServerType==0?"1":($cfgs->authServerType==1?"2":"unknown"));
				print "\n";
			}

			if ($supportedGlobals->autoProfile){
				print "Auto Profile: " . ($cfgs->autoProfile==0?"Off":"On");
				print "\n";
			}

			if ($supportedGlobals->bLRS){
				print "BG Channel Set: ";
				if ($cfgs->bLRS >= hexdec("3fff")){
					print "Full";
				}
				else if (dechex($cfgs->bLRS) == "0"){
					print "None";
				}
				else {
					$numChannels = new_ulongp();
					$channels = new LRD_WF_LRSChannels();
					$result = LRD_WF_GetbLRSChannels($numChannels, $channels, $cfgs->bLRS);
					if($result == SDCERR_SUCCESS){
						for($c = 0; $c < ulongp_value($numChannels); $c++) {
							print ulong_array_getitem($channels->chan,$c);
							if($c < (ulongp_value($numChannels) - 1)){
								print ",";
							}
						}
					}
					delete_ulongp($numChannels);
				}
				print "\n";
			}

			if ($supportedGlobals->BeaconMissTimeout){
				print "Beacon Miss Time: " . $cfgs->BeaconMissTimeout . " TUs";
				print "\n";
			}

			if ($supportedGlobals->BTcoexist){
				print "BT Coexist: " . ($cfgs->BTcoexist==0?"Off":"On");
				print "\n";
			}

			if ($supportedGlobals->CCXfeatures){
				print "CCX Features: " . ($cfgs->CCXfeatures==0?"Optimized":($cfgs->CCXfeatures==1?"Full":"Off"));
				print "\n";
			}

			if ($supportedGlobals->certPath){
				print "Certificate Path: " . $cfgs->certPath;
				print "\n";
			}

			if ($supportedGlobals->suppInfo){
				print "Date Check: " . ($cfgs->suppInfo & SUPPINFO_TLS_TIME_CHECK==0?"Off":"On");
				print "\n";
			}

			if ($supportedGlobals->defAdhocChannel){
				print "Default Adhoc Channel: " . $cfgs->defAdhocChannel;
				print "\n";
			}

			if ($supportedGlobals->DFSchannels){
				print "DFS Channels: " . ($cfgs->DFSchannels==0?"Off":"On");
				print "\n";
			}

			if (($supportedGlobals->suppInfo & 1)){
				$current = str_repeat(" ",1);
				$next = str_repeat(" ",1);
				$combined = 4;
				$result = LRD_WF_GetFipsStatus($current, $next);
				print "FIPS Mode: ";
				if ($result == SDCERR_SUCCESS){
					$combined = ((boolval(trim($current)) << 1) | boolval(trim($next)));
				}
				switch ($combined)
				{
					case 0: //FIPS_INACTIVE
						print "Disabled and Inactive";
						break;
					case 1: //FIPS_INACTIVE_ENABLED
						print "Inactive - Enabled on next start";
						break;
					case 2: //FIPS_ACTIVE_DISABLED
						print "Active - Disabled on next start";
						break;
					case 3: //FIPS_ACTIVE
						print "Enabled and Active";
						break;
					default:
						print "Unable to determine";
				}
				print "\n";
			}

			if ($supportedGlobals->fragThreshold){
				print "Fragmentation Threshold: " . $cfgs->fragThreshold . " bytes";
				print "\n";
			}

			if ($supportedGlobals->PMKcaching){
				print "PMK Caching: " . ($cfgs->PMKcaching==0?"Standard":"OPMK");
				print "\n";
			}

			if ($supportedGlobals->probeDelay){
				print "Probe Delay: " . $cfgs->probeDelay . " sec";
				print "\n";
			}

			if ($supportedGlobals->regDomain){
				print "Regulatory Domain: ";
				switch($cfgs->regDomain){
					case REG_FCC:
						print "FCC";
						break;
					case REG_ETSI:
						print "ETSI";
						break;
					case REG_TELEC:
						print "TELEC";
						break;
					case REG_WW:
						print "WW";
						break;
					case REG_KCC:
						print "KCC";
						break;
					case REG_CA:
						print "CA";
						break;
					case REG_FR:
						print "FR";
						break;
					case REG_GB:
						print "GB";
						break;
					case REG_AU:
						print "AU";
						break;
					case REG_NZ:
						print "NZ";
						break;
					case REG_CN:
						print "CN";
						break;
					case REG_BR:
						print "BR";
						break;
					case REG_RU:
						print "RU";
						break;
					default:
						print "Unknown: " . $cfgs->regDomain;
				}
				print "\n";
			}

			if ($supportedGlobals->roamDelta){
				print "Roam Delta: " . $cfgs->roamDelta;
				print "\n";
			}

			if ($supportedGlobals->roamPeriod){
				print "Roam Period: " . $cfgs->roamPeriod;
				print "\n";
			}

			if ($supportedGlobals->roamPeriodms){
				print "Roam Period ms: " . $cfgs->roamPeriodms . " ms";
				print "\n";
			}

			if ($supportedGlobals->roamTrigger){
				print "Roam Trigger: -" . $cfgs->roamTrigger . " dBm";
				print "\n";
			}

			if ($supportedGlobals->RTSThreshold){
				print "RTS Threshold: " . $cfgs->RTSThreshold . " bytes";
				print "\n";
			}

			if ($supportedGlobals->RxDiversity){
				print "Rx Diversity: ";
				switch($cfgs->RxDiversity){
					case RXDIV_MAIN:
						print "Main";
						break;
					case RXDIV_AUX:
						print "Aux";
						break;
					case RXDIV_START_AUX:
						print "Start-aux";
						break;
					case RXDIV_START_MAIN:
						print "Start-main";
						break;
					default:
						print "Unknown: " . $cfgs->RxDiversity;
				}
				print "\n";
			}

			if ($supportedGlobals->scanDFSTime){
				print "Scan DFS Time: " . $cfgs->scanDFSTime . " ms";
				print "\n";
			}

			if ($supportedGlobals->TTLSInnerMethod){
				print "TTLS Inner Method: ";
				switch($cfgs->TTLSInnerMethod){
					case TTLS_AUTO:
						print "Auto";
						break;
					case TTLS_MSCHAPV2:
						print "MSCHAPV2";
						break;
					case TTLS_MSCHAP:
						print "MSCHAP";
						break;
					case TTLS_PAP:
						print "PAP";
						break;
					case TTLS_CHAP:
						print "CHAP";
						break;
					case TTLS_EAP_MSCHAPV2:
						print "EAP-MSCHAPV2";
						break;
					default:
						print "Unknown: " . $cfgs->TTLSInnerMethod;
				}
				print "\n";
			}

			if ($supportedGlobals->TxDiversity){
				print "Tx Diversity: ";
				switch($cfgs->TxDiversity){
					case TXDIV_MAIN:
						print "Main";
						break;
					case TXDIV_AUX:
						print "Aux";
						break;
					case TXDIV_ON:
						print "On";
						break;
					default:
						print "Unknown: " . $cfgs->TxDiversity;
				}
				print "\n";
			}

			if ($supportedGlobals->txMax){
				print "TX Max: " . $cfgs->txMax . " %";
				print "\n";
			}

			if ($supportedGlobals->uAPSD){
				print "UAPSD: " . ($cfgs->uAPSD==0?"Off":"On");
				print "\n";
			}

			if ($supportedGlobals->WMEenabled){
				print "WMM: " . ($cfgs->WMEenabled==0?"Off":"On");
				print "\n";
			}

			print "\n";
		}
	}
}
delete_RADIOCHIPSETp($rcs);

?>
