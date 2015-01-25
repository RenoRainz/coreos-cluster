#!/bin/bash

# Clean du fichier host
>/etc/hosts
# Mise a jour du fichier
# Decouverte des noms de domaines
for i in `etcdctl ls /domains/`;
do domain=`/usr/bin/basename $i`;
        for j in `etcdctl ls /domains/$domain/`;do etcdctl get $j | awk -v d=$domain -F\: '{print $2 " " $1 " " $1"."d}' | tr -d {}\"   >>/etc/hosts;done;
done;