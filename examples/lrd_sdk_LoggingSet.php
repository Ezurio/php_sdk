<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
    print "ERROR: failed to load lrd_php_sdk\n";
    exit();
}

function SupplicantOptions($msg)
{
	print"\nInvalid Parameter: $msg - Valid values: \n";
	print"\t0 or none\n";
	print"\t1 or error\n";
	print"\t2 or warning\n";
	print"\t3 or info\n";
	print"\t4 or debug\n";
	print"\t5 or msgdump\n";
	print"\t6 or excessive\n";;
}

function DriverOptions( $msg )
{
	print"\nInvalid Parameter: $msg - Valid values: \n";
	print"\t0 or none\n";
	print"\t1 or low\n";
	print"\t2 or medium\n";
	print"\t3 or high\n";
}

$property = "driver";
$value = "0";
if ($property == "supplicant") {
	if (($value == "none") || ($value=="0"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_NONE);
	else if (($value == "error") || ($value=="1"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_ERROR);
	else if (($value == "warning") || ($value=="2"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_WARNING);
	else if (($value == "info") || ($value=="3"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_INFO);
	else if (($value == "debug") || ($value=="4"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_DEBUG);
	else if (($value == "msgdump") || ($value=="5"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_MSGDUMP);
	else if (($value == "excessive") || ($value=="6"))
		$result = LRD_WF_SetSuppLogLevel(WF_SUPP_DBG_EXCESSIVE);
	else {
		SupplicantOptions( $value );
	}
}else if ($property == "driver") {
	if (($value == "none") || ($value=="0"))
		$result = LRD_WF_Driver_set_debug(LRD_WF_DRV_DEBUG_NONE,0);
	else if (($value == "low") || ($value=="1"))
		$result = LRD_WF_Driver_set_debug(LRD_WF_DRV_DEBUG_LOW,0);
	else if (($value == "medium") || ($value=="2"))
		$result = LRD_WF_Driver_set_debug(LRD_WF_DRV_DEBUG_MED,0);
	else if (($value == "high") || ($value=="3"))
		$result = LRD_WF_Driver_set_debug(LRD_WF_DRV_DEBUG_HIGH,0);
	else {
		DriverOptions( $value );
	}
}else
{
	print"\nInvalid Property";
}

print"\n";
?>
