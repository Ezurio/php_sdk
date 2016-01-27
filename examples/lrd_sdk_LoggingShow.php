<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
    print "ERROR: failed to load lrd_php_sdk\n";
    exit();
}

function showSupplicantloglevel()
{
	$level = new_WF_SUPP_LOGLEVELp();
	if (LRD_WF_GetSuppLogLevel($level)==SDCERR_SUCCESS){
		$result = WF_SUPP_LOGLEVELp_value($level);
		print"\nsupplicant log level: $result";
	} else
		print"\nsupplicant: unable to determine log level";
	delete_WF_SUPP_LOGLEVELp($level);
}

function showDriverloglevel()
{
	$level = new_LRD_WF_DRV_DEBUGp();
	if (LRD_WF_Driver_get_debug($level, NULL)==SDCERR_SUCCESS){
		$result = LRD_WF_DRV_DEBUGp_value($level);
		print"\ndriver log level: $result";
	} else
		print"\ndriver: unable to determine log level";
	delete_LRD_WF_DRV_DEBUGp($level);
}

$strLog = "";
if ($strLog == ""){
	showSupplicantloglevel();
	showDriverloglevel();
}elseif($strLog == "supplicant"){
	showSupplicantloglevel();
}elseif ($strLog == "driver"){
	showDriverloglevel();
}else {
	print"\nInvalid property";
}
print"\n";
?>
