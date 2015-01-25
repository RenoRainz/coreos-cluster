#!/bin/bash

# Script qui parse le cluster etcd
# Pour mettre le fichier /etc/hosts
parser="/usr/local/bin/json-parser.bash"
# Test si le parser de json est present
if [ ! -x $parser ]
        then
                echo "Parser not found !"
                exit 1
fi

# Clean du fichier hosts
>/etc/hosts

# Recuperation des informations local
ip_local=$(ifconfig eth0 | grep inet | grep -v inet6  | awk '{print $2}' | tr -d addr\:)
hostname=$(hostname)
gateway=$(/sbin/ip route | awk '/default/ { print $3 }')
# Mise a jours des info local

echo "$ip_local $hostname" >> /etc/hosts

# Recuperation des domaines
domains=$(curl -Ls http://$gateway:4001/v2/keys/domains | $parser -b |grep key |grep nodes | awk '{print $2}' |tr -d \")
#echo $domains

# On parser les domaines pour mettre a jour les hosts
for i in $domains
do dn=$(basename $i)
        #echo $dn
        listhosts=$(curl -Ls http://$gateway:4001/v2/keys/$i  | $parser -b |  grep key | grep nodes | awk '{print $2}' |tr -d \")
        for j in $listhosts
        do host=$(basename $j)
                info=$(curl -Ls http://$gateway:4001/v2/keys/$j | $parser -b |grep node |grep value  | awk '{print $2 }' |tr -d \"{})
                iphost=$(echo $info |awk -F\: '{print $2}')
                echo "$iphost $host $host.$dn" >> /etc/hosts
        done
done
