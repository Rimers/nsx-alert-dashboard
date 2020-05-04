<?php

## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: AlertHandler

# Load Config & Function file
    include_once("config.php");
    include_once("functions.php");

# Check if we need to get ReverseLookupJsonFile.
    if ($ReverseLookup)
        {
            try
                {
                    $ReverseLookupJsonFileData = json_decode(file_get_contents($ReverseLookupJsonFilePath), true);
                }
            catch (\Throwable $th)
                {
                   echo "ERROR: Could not load ReverseLookupJsonFile : " . $th;
                   die();
                }
            
        }

# Load inbound datalogs 
        $GetLogs = mysqli_query($MySQLConnection, "SELECT * from vrli_webhook_inbound WHERE state = 'new' LIMIT " . $NumberOfLogsToExecute);
        while ($row = mysqli_fetch_assoc($GetLogs))
            {
                # Get data from database
                    $RawLogBundle = json_decode($row["data"], true);

                # Foreach Log
                    foreach ($RawLogBundle["messages"] as $Log => $value)
                        {

                            $WebhookID = $row["id"];
                            $Hostname = FindFieldValue($value["fields"], "hostname");
                            $FWAction = FindFieldValue($value["fields"], "vmw_nsxt_firewall_action");
                            $FWDST = FindFieldValue($value["fields"], "vmw_nsxt_firewall_dst");
                            $FWProtocol = FindFieldValue($value["fields"], "vmw_nsx_firewall_protocol");
                            $FWSOURCE = FindFieldValue($value["fields"], "vmw_nsxt_firewall_src");
                            $FWDSTPort = FindFieldValue($value["fields"], "vmw_nsxt_firewall_dst_port");
                            $FWDSTIPPORT = FindFieldValue($value["fields"], "vmw_nsxt_firewall_dst_ip_port");

                            # Get Tag/TCP flag

                                switch ($FWProtocol)
                                    {
                                        case 'TCP':
                                                $tmp = explode($FWDSTIPPORT, $value["text"])[1];
                                                $tmp = explode(" ", $tmp);
                                                $FWTCPFLAG = $tmp[1];
                                                $FWTag = $tmp[2];
                                                    break;
                                        
                                        case 'ICMP':
                                                $FWTag = trim(explode("".$FWSOURCE."->".$FWDST."", $value["text"])[1]);
                                                $FWTCPFLAG = "";
                                                    break;

                                        case 'UDP':
                                                $FWTag = trim(explode("->".$FWDSTIPPORT."", $value["text"])[1]);
                                                $FWTCPFLAG = "";
                                                    break;

                                        default:
                                            $FWTag = "";
                                            $FWTCPFLAG = "";
                                                    break;
                                    }
                            
                            # Check if reverse is enabled and if so, make reverselookup
                                if ($ReverseLookup)
                                    {
                                        $ReverseLookupSourceResult = ReverseLookup($FWSOURCE);
                                        $ReverseLookupDestinationResult = ReverseLookup($FWDST);
                                    }
                                else
                                    {
                                        $ReverseLookupSourceResult = "";
                                        $ReverseLookupDestinationResult = "";
                                    }


                            

                            # Check if we need to duplicate alert or just merge:
                                if ($MergeDuplicateAlerts)
                                    {
                                        # We need to dethermine if there is already an active alert
                                            $CheckLogs = mysqli_query($MySQLConnection, "SELECT id 
                                                FROM vrli_alerts 
                                                    WHERE 
                                                        vmw_nsxt_firewall_src = '".$FWSOURCE."' AND
                                                        vmw_nsxt_firewall_dst = '".$FWDST."' AND
                                                        vmw_nsxt_firewall_dst_port = '".$FWDSTPort."' AND
                                                        alert_status = 'new'
                                                    LIMIT 1");

                                            # Check number
                                                if (mysqli_num_rows($CheckLogs) > 0)
                                                    {
                                                        # Get ID of row, and make the new one duplicate
                                                            $AlertStatus = "duplicate";
                                                            $AlertParentID = mysqli_fetch_assoc($CheckLogs)["id"];
                                                    }
                                                else
                                                    {
                                                        $AlertStatus = "new";
                                                        $AlertParentID = "0";
                                                    }
                                    }
                                else
                                    {
                                        $AlertStatus = "new";
                                        $AlertParentID = "0";
                                    }

                            # Check if we need to ignore Highport
                                    if ($IgnoreHighPorts)
                                        {
                                            # Check if the destination port is higher than 49152-65535
                                            if ($FWDSTPort >= 49152 AND $FWDSTPort <= 65535)
                                                {
                                                    $AlertStatus = "fixed";
                                                }
                                        }

                            # Insert into database
                            $NewLog = mysqli_query($MySQLConnection, "INSERT INTO vrli_alerts SET 
                               hostname = '".$Hostname."', 
                                alert_webhook_id = '".$WebhookID."',
                                vmw_nsxt_firewall_src = '".$FWSOURCE."',
                                reverse_src = '".$ReverseLookupSourceResult."',
                                vmw_nsxt_firewall_dst = '".$FWDST."',
                                reverse_dst = '".$ReverseLookupDestinationResult."',
                                vmw_nsx_firewall_protocol = '".$FWProtocol."',
                                vmw_nsxt_firewall_action = '".$FWAction."',
                                vmw_nsxt_firewall_dst_port = '".$FWDSTPort."',
                                vmw_nsxt_firewall_dst_ip_port = '".$FWDSTIPPORT."',
                                logging_tag	= '".$FWTag."',
                                logging_tcp_flags = '".$FWTCPFLAG."',
                                alert_parent_id = '".$AlertParentID."',
                                alert_status = '".$AlertStatus."'");
                        }

                    # Set Webhook as finish
                       $UpdateQuery = mysqli_query($MySQLConnection, "UPDATE vrli_webhook_inbound SET state = 'fixed' WHERE id = '".$WebhookID."'");
                        
            }

?>