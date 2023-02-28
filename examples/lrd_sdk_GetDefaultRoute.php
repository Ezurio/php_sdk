<?php

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

//Interface can be null, first default route found will be returned
$interface = null;
$DefaultRoute = new DEFAULT_ROUTE();
$result = LRD_WF_GetDefaultRoute($DefaultRoute, LRD_ROUTE_FILE, $interface);

if ($result == SDCERR_SUCCESS){
	print "DCHP IPv4 Info:" . "\n";
	#NOTE - The DEFAULT_ROUTE struct contains a char interface
	#'interface' is a PHP keyword, swig renames it to 'c_interface'
	print "\tInterface: " . $DefaultRoute->c_interface . "\n";
	print "\tDestination: " . $DefaultRoute->destination . "\n";
	print "\tGateway: " . $DefaultRoute->gateway . "\n";
	print "\tFlags: " . $DefaultRoute->flags . "\n";
	print "\tMetric: " . $DefaultRoute->Metric . "\n";
	print "\tSubnet mask: " . $DefaultRoute->subnet_mask . "\n";
	print "\tMTU: " . $DefaultRoute->mtu . "\n";
	print "\tWindow: " . $DefaultRoute->window . "\n";
	print "\tIRTT: " . $DefaultRoute->irtt . "\n";

} else {
	print "Error - return code: $result\n";
}

return $result;
?>