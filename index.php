<?php

## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: FRONTEND - INDEX

# Load Config & Function file
include_once("config.php");
include_once("functions.php");

# Get data from database
    $GetDataDROP = mysqli_query($MySQLConnection, "SELECT * FROM vrli_alerts WHERE alert_status = 'new' AND vmw_nsxt_firewall_action = 'DROP'");
    $GetDataPASS = mysqli_query($MySQLConnection, "SELECT * FROM vrli_alerts WHERE alert_status = 'new' AND vmw_nsxt_firewall_action = 'PASS'");
    $GetDataWAIT = mysqli_query($MySQLConnection, "SELECT * FROM vrli_alerts WHERE alert_status = 'wait'");	

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $Title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <script>
    function OnSelectionChange(alertid, select)
    {
        var selectedOption = select.options[select.selectedIndex];
        var xhttp = new XMLHttpRequest();

        xhttp.open("GET", "editor.php?do=changealertstate&alertid=" + alertid + "&state=" + selectedOption.value + "",true);
        xhttp.send();
        location.reload();
    }

    function timedRefresh(timeoutPeriod)
    {
        setTimeout("location.reload(true);", timeoutPeriod);
    }

    window.onload = timedRefresh(30000);
    
    </script>
    <div class="limiter">
        <?php echo "LAST-UPDATE: " . date("d-m-Y H:i:s"); ?>
        <div class="container-table100">
            <div class="wrap-table100">
                <br>DROPS:<br>
                <div class="table">

                    <div class="row header">
                        <div class="cell">
                            Time
                        </div>
                        <div class="cell">
                            Action
                        </div>
                        <div class="cell">
                            Source
                        </div>
                        <div class="cell">
                            Destination/Port
                        </div>
                        <div class="cell">
                            Protocol (Flag)
                        </div>
                        <div class="cell">
                            TAG
                        </div>
                        <div class="cell">
                            State
                        </div>
                    </div>

<?php
    
	while ($row = mysqli_fetch_assoc($GetDataDROP))
		{
			# Variables
				$Source = $row["source"];
				$Destination = $row["destination"];
			
                ?>
                    <div class="row">
                        <div class="cell"><?php echo date('d-m-Y H:i:s', (int) $row["timestamp"]/1000);  ?></div>
                        <div class="cell"><?php echo $row["vmw_nsxt_firewall_action"]; ?></div>

                        <div class="cell">
                            <?php echo $row["vmw_nsxt_firewall_src"]; ?><br><?php echo $row["reverse_src"]; ?></div>
                        <div class="cell">
                            <?php if($row["vmw_nsxt_firewall_dst_ip_port"]) { echo $row["vmw_nsxt_firewall_dst_ip_port"]; } else { echo $row["vmw_nsxt_firewall_dst"]; }; ?><br><?php echo $row["reverse_dst"]; ?>
                        </div>
                        <div class="cell"><?php echo $row["vmw_nsx_firewall_protocol"]; ?>
                            <?php if($row["logging_tcp_flags"]) { echo "(". $row["logging_tcp_flags"] . ")"; } ?></div>
                        <div class="cell"><?php echo $row["logging_tag"]; ?></div>
                        <div class="cell"><select name='state'
                                onchange="OnSelectionChange('<?php echo $row["id"]; ?>',this)">
                                <option <?php if ($row["state"] == "new") { echo "selected"; } ?>>new</option>
                                <option <?php if ($row["state"] == "wait") { echo "selected"; } ?>>wait</option>
                                <option <?php if ($row["state"] == "fixed") { echo "selected"; } ?>>fixed</option>
                            </select></div>

                    </div>
                    <?php	}	?>

                </div><br>PASS:<br>
                <div class="table">
                    <div class="row header">
                        <div class="cell">
                            Time
                        </div>
                        <div class="cell">
                            Action
                        </div>
                        <div class="cell">
                            Source
                        </div>
                        <div class="cell">
                            Destination/Port
                        </div>
                        <div class="cell">
                            Protocol (Flag)
                        </div>
                        <div class="cell">
                            TAG
                        </div>
                        <div class="cell">
                            State
                        </div>
                    </div>

<?php
	while ($row = mysqli_fetch_assoc($GetDataPASS))
		{
		    ?>
                    <div class="row">
                        <div class="cell"><?php echo date('d-m-Y H:i:s', (int) $row["timestamp"]/1000);  ?></div>
                        <div class="cell"><?php echo $row["vmw_nsxt_firewall_action"]; ?></div>

                        <div class="cell">
                            <?php echo $row["vmw_nsxt_firewall_src"]; ?><br><?php echo $row["reverse_src"]; ?></div>
                        <div class="cell">
                            <?php if($row["vmw_nsxt_firewall_dst_ip_port"]) { echo $row["vmw_nsxt_firewall_dst_ip_port"]; } else { echo $row["vmw_nsxt_firewall_dst"]; }; ?><br><?php echo $row["reverse_dst"]; ?>
                        </div>
                        <div class="cell"><?php echo $row["vmw_nsx_firewall_protocol"]; ?>
                            <?php if($row["logging_tcp_flags"]) { echo "(". $row["logging_tcp_flags"] . ")"; } ?></div>
                        <div class="cell"><?php echo $row["logging_tag"]; ?></div>
                        <div class="cell"><select name='state'
                                onchange="OnSelectionChange('<?php echo $row["id"]; ?>',this)">
                                <option <?php if ($row["state"] == "new") { echo "selected"; } ?>>new</option>
                                <option <?php if ($row["state"] == "wait") { echo "selected"; } ?>>wait</option>
                                <option <?php if ($row["state"] == "fixed") { echo "selected"; } ?>>fixed</option>
                            </select></div>

                    </div>
                    <?php
		}
		    ?>
                </div>
                <br>WAIT:<br>
                <div class="table">

                    <div class="row header">
                        <div class="cell">
                            Time
                        </div>
                        <div class="cell">
                            Action
                        </div>
                        <div class="cell">
                            Source
                        </div>
                        <div class="cell">
                            Destination/Port
                        </div>
                        <div class="cell">
                            Protocol (Flag)
                        </div>
                        <div class="cell">
                            TAG
                        </div>
                        <div class="cell">
                            State
                        </div>
                    </div>

 <?php
	while ($row = mysqli_fetch_assoc($GetDataWAIT))
		{
			?>
                    <div class="row">
                        <div class="cell"><?php echo date('d-m-Y H:i:s', (int) $row["timestamp"]/1000);  ?></div>
                        <div class="cell"><?php echo $row["vmw_nsxt_firewall_action"]; ?></div>

                        <div class="cell">
                            <?php echo $row["vmw_nsxt_firewall_src"]; ?><br><?php echo $row["reverse_src"]; ?></div>
                        <div class="cell">
                            <?php if($row["vmw_nsxt_firewall_dst_ip_port"]) { echo $row["vmw_nsxt_firewall_dst_ip_port"]; } else { echo $row["vmw_nsxt_firewall_dst"]; }; ?><br><?php echo $row["reverse_dst"]; ?>
                        </div>
                        <div class="cell"><?php echo $row["vmw_nsx_firewall_protocol"]; ?>
                            <?php if($row["logging_tcp_flags"]) { echo "(". $row["logging_tcp_flags"] . ")"; } ?></div>
                        <div class="cell"><?php echo $row["logging_tag"]; ?></div>
                        <div class="cell"><select name='state'
                                onchange="OnSelectionChange('<?php echo $row["id"]; ?>',this)">
                                <option <?php if ($row["state"] == "new") { echo "selected"; } ?>>new</option>
                                <option <?php if ($row["state"] == "wait") { echo "selected"; } ?>>wait</option>
                                <option <?php if ($row["state"] == "fixed") { echo "selected"; } ?>>fixed</option>
                            </select></div>

                    </div>
                    <?php
		}
		    ?>
                </div>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>