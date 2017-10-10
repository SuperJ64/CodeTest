#!/bin/bash

cd /var/www && composer update
mysql -uroot -proot scotchbox < tables.sql