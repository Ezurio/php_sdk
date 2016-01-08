<?php
include("../lrd_php_sdk.php");
$ENABLE = 0;
$DISABLE = -1;
$EMPTY = -2;

if( !extension_loaded('lrd_php_sdk') )
{
	global $ENABLE, $DISABLE, $EMPTY;
	print "ERROR: failed to load lrd_php_sdk\n";
	exit();
}

function checkLine($line){
	global $ENABLE, $DISABLE, $EMPTY;
	$trimmed = trim($line);
	$pos = strpos($trimmed, '#');
	$line = explode(" ", $trimmed);
	$result = count($line);
	if($pos === 0){
		return $DISABLE;
	} elseif($result <= 1){
		return $EMPTY;
	} else{
		return $ENABLE;
	}
}

if(file_exists('/etc/network/interfaces')){
	global $ENABLE, $DISABLE, $EMPTY;
	$handle = fopen("/etc/network/interfaces", "r");
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
			$pos = strpos($line, 'iface');
			if((checkLine($line) == $ENABLE) && ($pos !== FALSE)){
				print"$line";
				while ((($line = fgets($handle)) !== false) && (checkLine($line) != $EMPTY)) {
					if(checkLine($line) == $DISABLE){
					}else {
						print"  $line";
					}
				}
				print"\n";
			}
		}
		fclose($handle);
	}
	$handle = fopen("/etc/network/interfaces", "r");
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
			$pos = strpos($line, 'auto');
			if((checkLine($line) == $ENABLE) && ($pos !== FALSE)){
				print"$line";
			}
		}
		fclose($handle);
	}
} else{
	print"\nENI File does not exist";
}
print"\n";
?>
