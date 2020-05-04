# NSX-alert-Dashboard is used for VMware NSX microsegmentation projects to help handling the massive amount of traffic and add the rules accordingly.

## Installation
1. Create virtual machine or docker lamp image
2. GIT clone to the desired directory, may be /var/www/ or /var/www/html/ (git clone https://github.com/sorenisager/nsx-alert-dashboard)
3. Change the config file with your desired settings
4. Import SQL file into MariaDB/MySQL database to get it to work
5. Test if it works, if not - check errors or let me help you.
6. Setup cronjob against http://sitename/alerthandler.php ex. every minute

For the NSX to send logs, please take a look at my blog on how to Microsegmentate.

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