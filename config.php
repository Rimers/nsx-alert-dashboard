<?php

## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: CONFIG FILE

# Site Configuration
    $Title = "NSX Microsegmentation Alert Dashboard";

# Alertconfiguration
    $IgnoreHighPorts = true; # True = Not showing (Default) -- False = Showing
    $ReverseLookup = true; # True = Try to lookup known servers (Default) -- False = Do not try to lookup (Faster)
    $ReverseLookupJsonFilePath = "ReverseLookup.json"; # Filepath for the ReverseLookup in json format
    $MergeDuplicateAlerts = true; # True = Instead of making a new alarm for existing source-destination-port, just make a reference to existing alert (Default) --- False = Make a new alert of every alarms even then alarm exists
    $NumberOfLogsToExecute = 300; # 5 Default - Number of executions of logs at every job run

# MySQL Config
$MysqlHost = "localhost"; # Insert FQDN on remote mysql database server or localhost if the mysql is hosted on the same server
$MysqlUserName = "mysqluser"; # Username for login
$MysqlPassword = "password"; # Password for login
$MysqlDatabase = "database"; # Database to connect
    

# MySQL Connection
    $MySQLConnection = mysqli_connect(
                    $MysqlHost,
                    $MysqlUserName,
                    $MysqlPassword,
                    $MysqlDatabase
                );

    # Error handling
        if (!$MySQLConnection)
            {
                die("Connection failed: " . mysqli_connect_error());
            }

?>