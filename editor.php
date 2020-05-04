<?php
## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: Editor


# Load Editor file
    include_once("config.php");
    include_once("functions.php");

if ($_GET["do"] == "changealertstate")
{
	# Variables
		$state = $_GET["state"];
		$alertid = $_GET["alertid"];
		
		$Update = mysqli_query($MySQLConnection, "UPDATE vrli_alerts SET alert_status = '".$state."' WHERE id = '".$alertid."'");
}

?>