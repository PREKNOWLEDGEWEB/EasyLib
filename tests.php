<?php
include("EasySDK.php");
try{
	import("xml_encode");
	echo $hi;
}
catch(Exception $e) {
	new_ErrorrHandle($e);
}
