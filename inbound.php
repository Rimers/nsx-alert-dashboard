<?php

## This code is written by Soren Isager @ sorenisager.com 2020
## This code is licenced under MIT License
## APP: INBOUND

# Collect data
    $data = file_get_contents('php://input');

# Load Config file
    include_once("config.php");

# Check if data exists
    if (isset($data))
        {
            # Insert data into database
                $QueryInsert = mysqli_query($MySQLConnection,"INSERT INTO vrli_webhook_inbound set data = '".$data."', state = 'new'");
        }

?>

