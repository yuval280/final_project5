#!/bin/bash
echo "restoring the site's details"
docker cp ./backup_html/html/. joomla-web:/var/www/html
sleep 3
echo "restoring the data base"
docker exec -i joomla-mysql mysql -ujoomla -pjoomla joomla < backup.sql
echo "restore completed"
