<html>
<head>
</head>
<body>
<?php
include("../lrd_php_sdk.php");

if( extension_loaded('lrd_php_sdk') )
{
	print "successfully loaded lrd_php_sdk!\n\n";
}
else
{
	print "ERROR: failed to load lrd_php_sdk\n";
}

$versionNumH = new_ulongp();
$rval = GetSDKVersion( $versionNumH );
$versionNum = dechex(ulongp_value($versionNumH));
print "GetSDKVersion returned $rval\n";
print "     version: $versionNum \n";

$statusH = new CF10G_STATUS();
$rval = GetCurrentStatus( $statusH );
print "GetCurrentStatus returned $rval\n";
print "     state: $statusH->cardState\n";

$interfaceName = ".................";
$rval = GetWifiInterfaceName($interfaceName);
print "GetWifiInterfaceName returned $rval\n";
print "     interface: $interfaceName \n";

?>
</body>

</html>