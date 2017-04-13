* Set up

```
#!php
# How to setup Virtualhost in Apache

XAMPP : XAMPP_PATH\apache\conf\extra\httpd-vhosts.conf

variables :
    $IP
    $TOMATOCAKE_PATH
    $DOMAIN_NAME

<VirtualHost $IP:80>
    ServerAdmin admin@tomatocake.com
    DocumentRoot "$TOMATOCAKE_PATH"
    ServerName $DOMAIN_NAME
    ServerAlias $DOMAIN_NAME
    ErrorLog "logs/$DOMAIN_NAME-error.log"
    CustomLog "logs/$DOMAIN_NAME-access.log" common

    SetEnv APP_ENV default
    <Directory "$TOMATOCAKE_PATH">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

=============================================================================================

# Edit host file
  windwos
    C:\Windows\System32\drivers\etc\hosts

$IP $DOMAIN_NAME

=============================================================================================

# Import database schema /tomatocake/schema/tomatocake.sql.tar.bz2



