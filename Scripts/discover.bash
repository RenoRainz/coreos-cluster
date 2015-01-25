#!/bin/bash

# Script qui gere l'annonce de l'ip
# du container dans le cluster etcd

if [ ! $# -eq 3 ]
then
        echo "Usage : discover.bash [set|del] container-name domain"
        exit 1
fi

ACTION=$1
CONTAINER_NAME=$2
DOMAIN=$3

function set {
        get-ip
        etcdctl set /domains/$DOMAIN/$CONTAINER_NAME "{$CONTAINER_NAME:$IP}" --ttl 60
}

function del {
        etcdctl rm  /domains/$DOMAIN/$CONTAINER_NAME
}

function get-ip {
        id=`docker ps |grep $CONTAINER_NAME  | awk '{print $1}'`
        if [ -n "$id" ]
        then
                IP=`docker inspect $id | grep IPAddress | awk '{print $2}' | tr -d \"\,`
        else
                echo "Container not found"
                exit 2
        fi
}

# Main

case $ACTION in

        set)
                set
        ;;

        del)
                del
        ;;

        *)
                echo "Action : [set|del]"
        ;;
esac