#!/bin/bash

# Script to register 
# apache backend to the redis server.

# Get ip of container
IP=$(cat /etc/hosts | grep `hostname` |awk '{print $1}')

for i in `ls /etc/apache2/sites-enabled/`
do
        SERVERNAME=$(cat /etc/apache2/sites-enabled/$i | grep ServerName  | awk '{print $2}')
        PJNAME=$(echo $SERVERNAME | awk -F\. '{print $1}')

        # Check 1rt entry in redis for this domain
        OUTPUT=`redis-cli -h redis-server lrange frontend:$SERVERNAME 0 0 | grep $PJNAME`
        if [ -z $OUTPUT ]
        then
                redis-cli -h redis-server rpush frontend:$SERVERNAME $PJNAME
        fi

        # Push backend conf to redis
        redis-cli -h redis-server rpush frontend:$SERVERNAME http://${IP}:80

done