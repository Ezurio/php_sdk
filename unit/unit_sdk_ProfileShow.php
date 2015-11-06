<?php

dl("lrd_php_sdk.so"); // Load it.
include("../lrd_php_sdk.php");

class StackTest extends PHPUnit_Framework_TestCase
{
	public function testLoaded()
	{
		$this->assertEquals(true, extension_loaded('lrd_php_sdk'));
	}

	public function testGetConfig()
	{
		$cfgs = new SDCConfig();
		$this->assertEquals(SDCERR_SUCCESS, GetConfig("Default",$cfgs));

		return $cfgs;
	}

	/**
	* @depends testGetConfig
	*/

	public function testGetMultipleWEPKeys($cfgs)
	{
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

		if ($cfgs->wepType == WEP_ON || $cfgs->wepType == WEP_CKIP){
			$this->assertEquals(SDCERR_SUCCESS, GetMultipleWEPKeys($cfgs,$wepIndex,$wepLen1,$wepKey1,$wepLen2,$wepKey2,$wepLen3,$wepKey3,$wepLen4,$wepKey4));
		}
		else{
			$this->assertEquals(SDCERR_INVALID_WEP_TYPE, GetMultipleWEPKeys($cfgs,$wepIndex,$wepLen1,$wepKey1,$wepLen2,$wepKey2,$wepLen3,$wepKey3,$wepLen4,$wepKey4));
		}
		if (($cfgs->wepType == WEP_ON || $cfgs->wepType == WEP_CKIP) && $cfgs->eapType != EAP_NONE){
			$this->assertEquals(SDCERR_INVALID_EAP_TYPE, GetMultipleWEPKeys($cfgs,$wepIndex,$wepLen1,$wepKey1,$wepLen2,$wepKey2,$wepLen3,$wepKey3,$wepLen4,$wepKey4));
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

	/**
	* @depends testGetConfig
	*/

	public function testGetPSK($cfgs)
	{
		$psk = str_repeat(" ",PSK_SZ);
		if($cfgs->wepType == WPA_PSK || $cfgs->wepType == WPA2_PSK || $cfgs->wepType == WPA_PSK_AES || $cfgs->wepType == WPA2_PSK_TKIP){
			$this->assertEquals(SDCERR_SUCCESS, GetPSK($cfgs,$psk));
		}
		else{
			$this->assertEquals(SDCERR_INVALID_WEP_TYPE, GetPSK($cfgs,$psk));
		}
		if (($cfgs->wepType == WPA_PSK || $cfgs->wepType == WPA2_PSK || $cfgs->wepType == WPA_PSK_AES || $cfgs->wepType == WPA2_PSK_TKIP) && $cfgs->eapType != EAP_NONE){
			$this->assertEquals(SDCERR_INVALID_EAP_TYPE, GetPSK($cfgs,$psk));
		}
	}

	/**
	* @depends testGetConfig
	*/

	public function testEAPcreds($cfgs){
		switch ($cfgs->eapType){
			case EAP_LEAP:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetLEAPCred($cfgs,$userName,$passWord));
				break;
			case EAP_EAPFAST:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$PACFileName = str_repeat(" ",CRED_PFILE_SZ);
				$PACPassWord = str_repeat(" ",CRED_PFILE_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetEAPFASTCred($cfgs,$userName,$passWord,$PACFileName,$PACPassWord));
				break;
			case EAP_PEAPMSCHAP:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetPEAPMSCHAPCred($cfgs,$userName,$passWord,$certLocation,$caCert));
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_PEAPGTC:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetPEAPGTCCred($cfgs,$userName,$passWord,$certLocation,$caCert));
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_EAPTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$userCert = str_repeat(" ",CRED_CERT_SZ);
				$userCertPassword = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetEAPTLSCred($cfgs,$userName,$userCert,$certLocation,$caCert));
				$this->assertEquals(SDCERR_SUCCESS, GetUserCertPassword($cfgs,$userCertPassword));
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_EAPTTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$passWord = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetEAPTTLSCred($cfgs,$userName,$passWord,$certLocation,$caCert));
				delete_CERTLOCATIONp($certLocation);
				break;
			case EAP_PEAPTLS:
				$userName = str_repeat(" ",USER_NAME_SZ);
				$userCert = str_repeat(" ",CRED_CERT_SZ);
				$userCertPassword = str_repeat(" ",USER_PWD_SZ);
				$certLocation = new_CERTLOCATIONp();
				$caCert = str_repeat(" ",CRED_CERT_SZ);
				$this->assertEquals(SDCERR_SUCCESS, GetPEAPTLSCred($cfgs,$userName,$userCert,$certLocation,$caCert));
				$this->assertEquals(SDCERR_SUCCESS, GetUserCertPassword($cfgs,$userCertPassword));
				delete_CERTLOCATIONp($certLocation);
				break;
		}

		free_SDCConfig($cfgs);
	}
}

?>