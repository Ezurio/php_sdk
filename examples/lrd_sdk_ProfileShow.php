<?php

if(!extension_loaded('lrd_php_sdk')){
        print "ERROR: failed to load lrd_php_sdk\n";
}

$cfgs = new SDCConfig();
$result = GetConfig("Default",$cfgs);
if($result == SDCERR_SUCCESS){
	print "Name: " . $cfgs->configName . "\n";
	print "SSID: " . $cfgs->SSID . "\n";
	print "Clientname: " . $cfgs->clientname . "\n";
	print "Tx Power: ";
	if ($cfgs->txPower == TXPOWER_MAX){
		print "Auto";
	}
	else{
		print "$cfgs->txPower";
	}
	print "\n";
	print "Auth Type: ";
	switch ($cfgs->authType){
	case AUTH_OPEN:
		print "Open";
		break;
	case AUTH_SHARED:
		print "Shared";
		break;
	case AUTH_NETWORK_EAP:
		print "EAP";
		break;
	default:
		print "Unknown: $cfgs->authType";
	}
	print "\n";
	print "EAP Type: ";
	switch ($cfgs->eapType){
		case EAP_NONE:
			print "None";
			break;
		case EAP_LEAP:
			print "LEAP";
			break;
		case EAP_EAPFAST:
			print "EAP-FAST";
			break;
		case EAP_PEAPMSCHAP:
			print "PEAP-MSCHAPV2";
			break;
		case EAP_PEAPGTC:
			print "PEAP-GTC";
			break;
		case EAP_EAPTLS:
			print "EAP-TLS";
			break;
		case EAP_EAPTTLS:
			print "EAP-TTLS";
			break;
		case EAP_PEAPTLS:
			print "PEAP-TLS";
			break;
		default:
			print "Unknown: $cfgs->eapType";
	}
	print "\n";
	print "WEP Type: ";
	switch ($cfgs->wepType){
		case WEP_OFF:
			print "None";
			break;
		case WEP_ON:
			print "WEP";
			break;
		case WEP_AUTO:
			print "WEP-EAP";
			break;
		case WPA_PSK:
			print "WPA-PSK-TKIP";
			break;
		case WPA_TKIP:
			print "WPA-TKIP";
			break;
		case WPA2_PSK:
			print "WPA2-PSK-AES";
			break;
		case WPA2_AES:
			print "WPA2-AES";
			break;
		case CCKM_TKIP:
			print "CCKM-TKIP";
			break;
		case WEP_CKIP:
			print "CKIP";
			break;
		case WEP_AUTO_CKIP:
			print "Auto-CKIP";
			break;
		case CCKM_AES:
			print "CCKM-AES";
			break;
		case WPA_PSK_AES:
			print "WPA-PSK-AES";
			break;
		case WPA_AES:
			print "WPA-AES";
			break;
		case WPA2_PSK_TKIP:
			print "WPA2-PSK-TKIP";
			break;
		case WPA2_TKIP:
			print "WPA2-TKIP";
			break;
		case WAPI_PSK:
			print "WAPI-PSK";
			break;
		case WAPI_CERT:
			print "WAPI-CERT";
			break;
		default:
			print "Unknown: $cfgs->wepType";
	}
	print "\n";
	print "Mode: ";
	switch ($cfgs->radioMode){
		case RADIOMODE_B_ONLY:
			print "B only";
			break;
		case RADIOMODE_BG:
			print "BG";
			break;
		case RADIOMODE_G_ONLY:
			print "G only";
			break;
		case RADIOMODE_BG_LRS:
			print "BG LRS";
			break;
		case RADIOMODE_A_ONLY:
			print "A only";
			break;
		case RADIOMODE_ABG:
			print "ABG";
			break;
		case RADIOMODE_BGA:
			print "BGA";
			break;
		case RADIOMODE_BGN:
			print "BGN";
			break;
		case RADIOMODE_GN:
			print "GN";
			break;
		case RADIOMODE_AN:
			print "AN";
			break;
		case RADIOMODE_ABGN:
			print "ABGN";
			break;
		case RADIOMODE_BGAN:
			print "BGAN";
			break;
		case RADIOMODE_ADHOC:
			print "AD-HOC";
			break;
		default:
			print "Unknown: $cfgs->radioMode";
	}
	print "\n";
	print "Power Save: ";
	switch ($cfgs->powerSave){
		case POWERSAVE_OFF:
			print "Off";
			break;
		case POWERSAVE_MAX:
			print "Max";
			break;
		case POWERSAVE_FAST:
			print "Fast";
			break;
		default:
			print "Unknown: $cfgs->powerSave";
	}
	print "\n";
	if ($cfgs->wepType == WEP_ON || $cfgs->wepType == WEP_CKIP){
		$wepIndex = new_intp();
		$wepLen = new_WEPLENp();
		$wepLen1 = new_WEPLENp();
		$wepLen2 = new_WEPLENp();
		$wepLen3 = new_WEPLENp();
		$wepLen4 = new_WEPLENp();

		$wepKey1 = new_uchar_array(27);
		$wepKey2 = new_uchar_array(27);
		$wepKey3 = new_uchar_array(27);
		$wepKey4 = new_uchar_array(27);

		$result = GetMultipleWEPKeys($cfgs,$wepIndex,$wepLen1,$wepKey1,$wepLen2,$wepKey2,$wepLen3,$wepKey3,$wepLen4,$wepKey4);
		if($result == SDCERR_SUCCESS){
			for($i=1;$i<5;$i++)
			{
				print "Index " . $i . ": ";
				if($i == intp_value($wepIndex)){
					print "tx ";
				}
				if($i == 1){
					WEPLENp_assign($wepLen,WEPLENp_value($wepLen1));
				}
				if($i == 2){
					WEPLENp_assign($wepLen,WEPLENp_value($wepLen2));
				}
				if($i == 3){
					WEPLENp_assign($wepLen,WEPLENp_value($wepLen3));
				}
				if($i == 4){
					WEPLENp_assign($wepLen,WEPLENp_value($wepLen4));
				}
				if(WEPLENp_value($wepLen) == WEPLEN_40BIT){
					print " *****";
				}
				else if(WEPLENp_value($wepLen) == WEPLEN_128BIT){
					print " ****************";
				}
				print "\n";
			}
		}

		delete_intp($wepIndex);
		delete_WEPLENp($wepLen);
		delete_WEPLENp($wepLen1);
		delete_WEPLENp($wepLen2);
		delete_WEPLENp($wepLen3);
		delete_WEPLENp($wepLen4);
		delete_uchar_array($wepKey1);
		delete_uchar_array($wepKey2);
		delete_uchar_array($wepKey3);
		delete_uchar_array($wepKey4);
	}
	if($cfgs->wepType == WPA_PSK || $cfgs->wepType == WPA2_PSK || $cfgs->wepType == WPA_PSK_AES || $cfgs->wepType == WPA2_PSK_TKIP){
		$psk = str_repeat(" ",PSK_SZ);
		$result = GetPSK($cfgs,$psk);
		print "PSK: ";
		if($result == SDCERR_SUCCESS){
			if(!empty(trim($psk[0]))){
				print "********\n";
			}
		}
		print "\n";
	}
	if($cfgs->eapType != EAP_NONE)
	{
		switch ($cfgs->eapType){
			case EAP_LEAP:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$result = GetLEAPCred($cfgs,$userName,$passWord);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "Password: ";
					if(!empty(trim($passWord[0]))){
						print "********";
					}
					print "\n";
				}
				break;
			case EAP_EAPFAST:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$PACFileName = str_repeat(" ",CRED_PFILE_SZ);
				$PACPassWord = str_repeat(" ",CRED_PFILE_SZ);
				$result = GetEAPFASTCred($cfgs,$userName,$passWord,$PACFileName,$PACPassWord);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "Password: ";
					if(!empty(trim($passWord[0]))){
						print "********";
					}
					print "\n";
					print "PAC Filename: ";
					if(!empty(trim($PACFileName))){
						print $PACFileName;
					}
					print "\n";
					print "PAC Password: ";
					if(!empty(trim($PACPassWord[0]))){
						print "********";
					}
					print "\n";
				}
				break;
			case EAP_PEAPMSCHAP:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$result = GetPEAPMSCHAPCred($cfgs,$userName,$passWord,$certLocation,$caCert);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "Password: ";
					if(!empty(trim($passWord[0]))){
						print "********";
					}
					print "\n";
					print "CA Cert: ";
					if(CERTLOCATIONp_value($certLocation) == CERT_FILE){
						if(!empty(trim($caCert))){
							print $caCert;
						}
					}
					print "\n";
				}
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_PEAPGTC:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$result = GetPEAPGTCCred($cfgs,$userName,$passWord,$certLocation,$caCert);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "Password: ";
					if(!empty(trim($passWord[0]))){
						print "********";
					}
					print "\n";
					print "CA Cert: ";
					if(CERTLOCATIONp_value($certLocation) == CERT_FILE){
						if(!empty(trim($caCert))){
							print $caCert;
						}
					}
					print "\n";
				}
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_EAPTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$userCert = str_repeat(" ",CRED_CERT_SZ);
				$userCertPassword = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$result = GetEAPTLSCred($cfgs,$userName,$userCert,$certLocation,$caCert);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "User Cert: ";
					if(empty(trim($userCert[0]))){
						print "None";
					} else {
						print "File";
					}
					print "\n";
					print "User Cert: ";
					if(!empty(trim($userCert))){
						print $userCert;
					}
					print "\n";
					print "User Cert Password: ";
					$result = GetUserCertPassword($cfgs,$userCertPassword);
					if($result == SDCERR_SUCCESS){
						if(!empty(trim($userCertPassword[0]))){
							print "********";
						}
					}
					print "\n";
					print "CA Cert: ";
					if(CERTLOCATIONp_value($certLocation) == CERT_FILE){
						if(!empty(trim($caCert))){
							print $caCert;
						}
					}
					print "\n";
				}
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_EAPTTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$result = GetEAPTTLSCred($cfgs,$userName,$passWord,$certLocation,$caCert);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "Password: ";
					if(!empty(trim($passWord[0]))){
						print "********";
					}
					print "\n";
					print "CA Cert: ";
					if(CERTLOCATIONp_value($certLocation) == CERT_FILE){
						if(!empty(trim($caCert))){
							print $caCert;
						}
					}
					print "\n";
				}
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_PEAPTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$userCert = str_repeat(" ",CRED_CERT_SZ);
				$userCertPassword = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$result = GetPEAPTLSCred($cfgs,$userName,$userCert,$certLocation,$caCert);
				if($result == SDCERR_SUCCESS){
					print "Username: ";
					if(!empty(trim($userName))){
						print $userName;
					}
					print "\n";
					print "User Cert: ";
					if(empty(trim($userCert[0]))){
						print "None";
					} else {
						print "File";
					}
					print "\n";
					print "User Cert: ";
					if(!empty(trim($userCert))){
						print $userCert;
					}
					print "\n";
					print "User Cert Password: ";
					$result = GetUserCertPassword($cfgs,$userCertPassword);
					if($result == SDCERR_SUCCESS){
						if(!empty(trim($userCertPassword[0]))){
							print "********";
						}
					}
					print "\n";
					print "CA Cert: ";
					if(CERTLOCATIONp_value($certLocation) == CERT_FILE){
						if(!empty(trim($caCert))){
							print $caCert;
						}
					}
					print "\n";
				}
				delete_CERTLOCATIONp($certLocation);
				break;
			default:
				print "Unknown: $cfgs->eapType";
		}
		print "\n";
	}
}
else{
	print "Failed to get config\n";
}
free_SDCConfig($cfgs);
?>