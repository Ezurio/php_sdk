<?php
include("../lrd_php_sdk.php");

if( !extension_loaded('lrd_php_sdk') )
{
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

$interface = "eth99";
$DHCPLease = new DHCP_LEASE();
$result = LRD_WF_GetDHCPIPv4Lease($DHCPLease, $interface);

if ($result == SDCERR_SUCCESS){
	if ($DHCPLease->message_type != 0){
		print "DCHP IPv4 Info:" . "\n";
		#NOTE - The DHCP_LEASE struct contains a char interface
		#'interface' is a PHP keyword, swig renames it to 'c_interface'
		print "\tInterface: " . $DHCPLease->c_interface . "\n";
		print "\tAddress: " . $DHCPLease->address . "\n";
		print "\tSubnet Mask: " . $DHCPLease->subnet_mask . "\n";
		print "\tRouters: " . $DHCPLease->routers . "\n";
		print "\tLease Time: " . $DHCPLease->lease_time . "\n";
		print "\tDNS Servers: " . $DHCPLease->dns_servers . "\n";
		print "\tDCHP Server: " . $DHCPLease->dhcp_server . "\n";
		print "\tDomain Name: " . $DHCPLease->domain_name . "\n";
		print "\tRenew: " . $DHCPLease->renew . "\n";
		print "\tRebind: " . $DHCPLease->rebind . "\n";
		print "\tExpire: " . $DHCPLease->expire . "\n";
	} else {
		print "No valid lease found for " . $interface . ".\n";
		return $result;
	}

} else {
	print "Error - return code: $result\n";
}

return $result;
?>