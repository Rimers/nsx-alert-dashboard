# NSX-alert-Dashboard is used for VMware NSX microsegmentation projects to help handling the massive amount of traffic and add the rules accordingly.

## Installation
1. Create virtual machine or docker lamp image (Could be like: https://www.howtoforge.com/tutorial/install-apache-with-php-and-mysql-on-ubuntu-18-04-lamp/)
2. GIT clone to the desired directory, may be /var/www/ or /var/www/html/ (git clone https://github.com/sorenisager/nsx-alert-dashboard)
3. Change the config file with your desired settings
4. Import SQL file into MariaDB/MySQL database to get it to work
5. Test if it works, if not - check errors or let me help you.
6. Setup cronjob against http://sitename/alerthandler.php ex. every minute
7. Add entries in the ReverseLookup file, so you can resolve the IP's in the log into servernames.

For the NSX to send logs, please take a look at my blog on how to Microsegmentate.

## ReverseLookup
Gives the Option in the config file to reverse lookup hostnames in the Alerthandler. Loginsight is not sending the servernames in the logs, so we can reverselookup.

Its a JSON file ex:
"10.10.100.85": "dhcp-server"

## Security
There is no page security at the moment added to the code, you may need to use .htaccess or other type of security to prevent others from seeing the applicationdata.

## Current Version - 1.0

The current version of the NSX-Alert-Dashboard

### Future Versions

There may be future versions, it depends on the demand.

## See It in Action

Look at sorenisager.com

## Requirements

* LAMP stack (PHP7+)
- MariaDB or MySQL is fine.

## Licensing

The software is free to use, but i can never behold responsible for anything.
