#!/usr/bin/env bash

# CRON
service cron start
## Add crone tasks

#Task for renew certificates
command="/usr/bin/certbot renew --quiet"
job="15 3 * * * $command"
cat <(fgrep -i -v "$command" <(crontab -l)) <(echo "$job") | crontab -

# Supervisor
#service supervisor start

# To have no issues with permissions
chown -R www-data:www-data /srv/app/storage
chown -R www-data:www-data /srv/app/bootstrap/cache

# Apache
apache2-foreground
