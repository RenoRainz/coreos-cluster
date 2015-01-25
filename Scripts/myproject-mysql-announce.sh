#!/bin/sh

#Recuperation de l id
id=`docker ps |grep myproject-mysql  | awk '{print $1}'`
#Recuperation de l'ip
ip=`docker inspect $id | grep IPAddress | awk '{print $2}' | tr -d \"\,`
etcdctl set /domains/example.lan/myproject-mysql "{myproject-mysql:$ip}" --ttl 60