#!/bin/bash
echo "backing up the data base:"
docker exec joomla-mysql sh -c 'exec mysqldump --no-tablespaces -ujoomla -pjoomla joomla' > backup.sql
echo "backing up the site's details:"
docker cp joomla-web:/var/www/html ./backup_html
echo "backup completed"
